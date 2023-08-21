<?php

use App\Http\Controllers\RatingsAndReviewsController;
use Illuminate\Support\Facades\Route;

// Protected routes
Route::post('rating', [RatingsAndReviewsController::class, 'addRating']); //@post::http://127.0.0.1:8000/api/orders
Route::get('rating', [RatingsAndReviewsController::class, 'getAllRating']); //@get::http://127.0.0.1:8000/api/orders
Route::get('rating/{id}', [RatingsAndReviewsController::class, 'indiviualRating']); //@get::http://127.0.0.1:8000/api/orders/id

Route::put('rating/{id}', [RatingsAndReviewsController::class, 'updateRating']); //@put::http://127.0.0.1:8000/api/orders/id
Route::delete('rating/{id}', [RatingsAndReviewsController::class, 'destroyRating']); //@delete::http://127.0.0.1:8000/api/orders/id

Route::get('averagerating/{id}', [RatingsAndReviewsController::class, 'averageRating']); //@get::http://127.0.0.1:8000/api/orders/id

