<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Protected routes
Route::post('books', [BookController::class, 'addBook']); //@post::http://127.0.0.1:8000/api/books
Route::get('books', [BookController::class, 'getAllBook']); //@get::http://127.0.0.1:8000/api/books
Route::get('books/{id}', [BookController::class, 'indiviualBook']); //@get::http://127.0.0.1:8000/api/books/id
Route::get('books/search/{categories}', [BookController::class, 'searchBook']); //@get::http://127.0.0.1:8000/api/books/search
Route::put('books/{id}', [BookController::class, 'updateBook']); //@put::http://127.0.0.1:8000/api/books/id
Route::delete('books/{id}', [BookController::class, 'destroyBook']); //@delete::http://127.0.0.1:8000/api/books/id
