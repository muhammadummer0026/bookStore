<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Protected routes
// Route::post('books', [BookController::class, 'addBook']); //@post::http://127.0.0.1:8000/api/books
// Route::middleware(['can:update or create image'])->post('UploadImage', [BookController::class, 'updateOrCreateImage']); //@post::http://127.0.0.1:8000/api/UploadImage
// Route::middleware(['can:get all books'])->get('books', [BookController::class, 'getAllBook']); //@get::http://127.0.0.1:8000/api/books
// Route::middleware(['can:get individual book'])->get('books/{id}', [BookController::class, 'indiviualBook']); //@get::http://127.0.0.1:8000/api/books/id
// Route::middleware(['can:search books'])->get('books/search/{categories}', [BookController::class, 'searchBook']); //@get::http://127.0.0.1:8000/api/books/search
// Route::middleware(['can:update book'])->put('books/{id}', [BookController::class, 'updateBook']); //@put::http://127.0.0.1:8000/api/books/id
// Route::middleware(['can:destroy book'])->delete('books/{id}', [BookController::class, 'destroyBook']); //@delete::http://127.0.0.1:8000/api/books/id

Route::middleware(['can:view_dashboard'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index');
});

Route::middleware(['can:update_or_create_image'])->group(function () {
    Route::post('/UploadImage', 'BookController@updateOrCreateImage');
});

Route::middleware(['can:get_all_books'])->group(function () {
    Route::get('/books', 'BookController@getAllBook');
});

Route::middleware(['can:get_individual_book'])->group(function () {
    Route::get('/books/{id}', 'BookController@indiviualBook');
});

Route::middleware(['can:search_books'])->group(function () {
    Route::get('/books/search/{categories}', 'BookController@searchBook');
});

Route::middleware(['can:update_book'])->group(function () {
    Route::put('/books/{id}', 'BookController@updateBook');
});

Route::middleware(['can:destroy_book'])->group(function () {
    Route::delete('/books/{id}', 'BookController@destroyBook');
});
