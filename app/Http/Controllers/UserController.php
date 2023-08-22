<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerUser(Request $request)              //register user
    {

        try {
            // $requestedEmail = $request->input('email');

            // // Check if the email already exists in the database
            // $existingUser = User::where('email', $requestedEmail)->first();

            // if ($existingUser) {
            //     return response()->json(['error' => 'Email already exists'], 409); // Conflict status code
            // }
            $user = User::create([
                'encrypted_id' => Str::uuid()->toString(),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => bcrypt($request->input('password')),
            ]);

            if ($user->role == 'admin') {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }

            if ($user) {
                // Generate the verification token after creating the user
                $verificationToken = hash('sha256', $user->id.Str::random(40));           //sha(secure hash algorithm)
                $user->verify_token = $verificationToken;
                $user->save();                                                  //save user

                $verificationUrl = route('verify.email', ['userId' => $user->id, 'token' => $verificationToken]);  //call route verify user
                Mail::to($user->email)->send(new VerificationEmail($verificationUrl));

                return response()->json(['message' => 'User registered successfully. Please check your email for verification.', 'user' => $user], 201);
            } else {
                return response()->json(['error' => 'Failed to register user'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verifyEmail(Request $request, $userId, $token)          //verify the email
    {
        $user = User::where('id', $userId)->where('verify_token', $token)->first();        //get user verify token and id

        if (! $user) {
            return response()->json(['message' => 'Invalid verification token'], 400);
        }

        $user->email_verified_at = now();             //if the user verifies, create a record of the time when the user verified it.
        $user->verify_token = null; // Clear the verification token
        $user->save();

        return redirect('http://127.0.0.1:8000');

    }

    public function getAllUser()
    {
        $users = User::all();                 //show all user

        return response()->json(['users' => $users]);
    }

    public function indiviualUser($id)             ////get user of specfic person
    {
        $users = User::where('id', $id)->get();    //get specfic data user

        if ($users->isEmpty()) {
            return response()->json(['error' => 'Users not found'], 404);
        } else {
            return response()->json(['users' => $users]);
        }
    }

    public function searchUser($username)   //search the order
    {
        $users = User::where('name', 'like', "%$username%")->get();   //get user where name is found

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found for the given username'], 404);
        }

        return response()->json(['users' => $users]);
    }

    public function updateUser(Request $request, $id)     //update the user
    {
        $users = User::where('id', $id)->first();     //get specfic user data

        if (! $users) {
            return response()->json(['error' => 'user not found'], 404);
        }

        $updateData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),

        ];

        try {
            $users->update($updateData);

            return response()->json(['message' => 'user updated successfully', 'users' => $users], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroyUser($id)            //delete the user
    {
        $user = User::where('id', $id)->first();      //get specfic user data
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // public function resendVerification(Request $request)
    // {
    //     $user = $request->user();
    //     $user->verify_token = hash('sha256', $user->id.Str::random(40)); // Generate a new verify token tied to the user's ID
    //     $user->save();

    //     $user->sendEmailVerificationNotification();

    //     return response()->json(['message' => 'Verification email has been resent.']);
    // }
}
