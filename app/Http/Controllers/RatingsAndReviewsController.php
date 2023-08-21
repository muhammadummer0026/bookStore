<?php

namespace App\Http\Controllers;

use App\Models\ratings_and_reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\RatingRequest;

class RatingsAndReviewsController extends Controller
{
    public function addRating(RatingRequest $request)        //add rating 
    {
        try {

            $rating = ratings_and_reviews::create([
                'rating_encrypted_id' => Str::uuid()->toString(),
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'rating' => $request->input('rating'),
                'review' => $request->input('review'),

            ]);

            if ($rating) {
                return response()->json(['message' => 'rating added sucessfully', 'rating' => $rating], 201);
            } else {
                return response()->json(['error' => 'Failed to add rating'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllRating()
    {
        $rating = ratings_and_reviews::all();              // show all books
        return response()->json(['rating' => $rating]);
    }

    public function indiviualRating($id)                     //get order of specfic person
    {
        $rating = ratings_and_reviews::where('id', $id)->get();            //get rating of specfic id

        if ($rating->isEmpty()) {
            return response()->json(['error' => 'rating not found'], 404);
        } else {
            return response()->json(['rating' => $rating]);
        }
    }

    public function averageRating($bookId)
    {
        try {
            $rating = ratings_and_reviews::where('book_id', $bookId)->pluck('rating');     //get specfic column e.g rating

            if ($rating->isEmpty()) {
                return response()->json(['error' => 'rating not found'], 404);
            }

            $averageRating = $rating->average();

            $latestRating = ($averageRating / 5) * 5;

            return response()->json(['average_rating' => $latestRating]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching ratings.'], 500);
        }
    }

    public function updateRating(Request $request, $id)      //update the rating data
    {
        $rating = ratings_and_reviews::where('id', $id)->first();  //get rating of specfic id

        if (! $rating) {
            return response()->json(['error' => 'rating not found'], 404);
        }

        $updateData = [
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ];

        try {
            $rating->update($updateData);

            return response()->json(['message' => 'rating updated successfully', 'rating' => $rating], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroyRating($id)             //delete the book
    {
        $rating = ratings_and_reviews::where('id', $id)->first();          //get  rating of specfic id
        if (! $rating) {
            return response()->json(['error' => 'rating not found'], 404);
        }

        $rating->delete();

        return response()->json(['message' => 'rating deleted successfully']);
    }
}
