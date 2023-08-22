<?php

use App\Http\Controllers\RatingsAndReviewsController;
use Illuminate\Support\Facades\Route;

// Protected routes

// Route::middleware(['can:add rating'])->post('rating', [RatingsAndReviewsController::class, 'addRating']); //@post::http://127.0.0.1:8000/api/orders
// Route::middleware(['can:get all ratings'])->get('rating', [RatingsAndReviewsController::class, 'getAllRating']); //@get::http://127.0.0.1:8000/api/orders
// Route::middleware(['can:get individual rating'])->get('rating/{id}', [RatingsAndReviewsController::class, 'indiviualRating']); //@get::http://127.0.0.1:8000/api/orders/id
// Route::middleware(['can:update rating'])->put('rating/{id}', [RatingsAndReviewsController::class, 'updateRating']); //@put::http://127.0.0.1:8000/api/orders/id
// Route::middleware(['can:destroy rating'])->delete('rating/{id}', [RatingsAndReviewsController::class, 'destroyRating']); //@delete::http://127.0.0.1:8000/api/orders/id
// Route::middleware(['can:average rating'])->get('averagerating/{id}', [RatingsAndReviewsController::class, 'averageRating']); //@get::http://127.0.0.1:8000/api/orders/id

Route::middleware(['can:add_rating'])->group(function () {
    Route::post('/rating', 'RatingsAndReviewsController@addRating');
});

Route::middleware(['can:get_all_ratings'])->group(function () {
    Route::get('/rating', 'RatingsAndReviewsController@getAllRating');
});

Route::middleware(['can:get_individual_rating'])->group(function () {
    Route::get('/rating/{id}', 'RatingsAndReviewsController@indiviualRating');
});

Route::middleware(['can:update_rating'])->group(function () {
    Route::put('/rating/{id}', 'RatingsAndReviewsController@updateRating');
});

Route::middleware(['can:destroy_rating'])->group(function () {
    Route::delete('/rating/{id}', 'RatingsAndReviewsController@destroyRating');
});

Route::middleware(['can:average_rating'])->group(function () {
    Route::get('/averagerating/{id}', 'RatingsAndReviewsController@averageRating');
});
