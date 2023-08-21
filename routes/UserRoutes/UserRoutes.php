<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [UserController::class, 'registerUser']);
Route::get('/verify/email/{userId}/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');
// Route::post('resend-verification', [UserController::class, 'verifyEmail'])->name('resend.verification');

// Protected routes
// Route::group(['middleware' => ['auth:api']], function () {
Route::get('users', [UserController::class, 'getAllUser']); //@get::http://127.0.0.1:8000/api/users
Route::get('users/{id}', [UserController::class, 'indiviualUser']); //@get::http://127.0.0.1:8000/api/users/id
Route::get('users/search/{name}', [UserController::class, 'searchUser']); //@get::http://127.0.0.1:8000/api/user/search
Route::put('users/{id}', [UserController::class, 'updateUser']); //@put::http://127.0.0.1:8000/api/users/id
Route::delete('users/{id}', [UserController::class, 'destroyUser']); //@delete::http://127.0.0.1:8000/api/users/id

// });
