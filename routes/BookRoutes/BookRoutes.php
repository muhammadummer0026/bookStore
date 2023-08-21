<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$adminRole = Role::create(['name' => 'admin']);
$adminRole = Role::create(['name' => 'user']);

Permission::create(['name' => 'add book']);
Permission::create(['name' => 'update or create image']);
Permission::create(['name' => 'get all books']);
Permission::create(['name' => 'get individual book']);
Permission::create(['name' => 'search books']);
Permission::create(['name' => 'update book']);
Permission::create(['name' => 'destroy book']);

$adminRole = Role::findByName('admin');
$userRole = Role::findByName('user');

$allPermissions = Permission::all();

$adminRole->syncPermissions($allPermissions);
$userRole->syncPermissions(['get all books', 'get individual book', 'search books']);

// Protected routes
Route::middleware(['can:add book'])->post('books', [BookController::class, 'addBook']); //@post::http://127.0.0.1:8000/api/books
Route::middleware(['can:update or create image'])->post('UploadImage', [BookController::class, 'updateOrCreateImage']); //@post::http://127.0.0.1:8000/api/UploadImage
Route::middleware(['can:get all books'])->get('books', [BookController::class, 'getAllBook']); //@get::http://127.0.0.1:8000/api/books
Route::middleware(['can:get individual book'])->get('books/{id}', [BookController::class, 'indiviualBook']); //@get::http://127.0.0.1:8000/api/books/id
Route::middleware(['can:search books'])->get('books/search/{categories}', [BookController::class, 'searchBook']); //@get::http://127.0.0.1:8000/api/books/search
Route::middleware(['can:update book'])->put('books/{id}', [BookController::class, 'updateBook']); //@put::http://127.0.0.1:8000/api/books/id
Route::middleware(['can:destroy book'])->delete('books/{id}', [BookController::class, 'destroyBook']); //@delete::http://127.0.0.1:8000/api/books/id
