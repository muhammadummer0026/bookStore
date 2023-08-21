<?php

use App\Http\Controllers\RatingsAndReviewsController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$adminRole = Role::create(['name' => 'admin']);
$adminRole = Role::create(['name' => 'user']);

Permission::create(['name' => 'add rating']);
Permission::create(['name' => 'get all ratings']);
Permission::create(['name' => 'get individual rating']);
Permission::create(['name' => 'update rating']);
Permission::create(['name' => 'destroy rating']);
Permission::create(['name' => 'average rating']);

$adminRole = Role::findByName('admin');
$userRole = Role::findByName('user');

$allPermissions = Permission::all();

$adminRole->syncPermissions($allPermissions);
$userRole->syncPermissions(['get all ratings', 'get individual rating', 'average rating']);

// Protected routes

Route::middleware(['can:add rating'])->post('rating', [RatingsAndReviewsController::class, 'addRating']); //@post::http://127.0.0.1:8000/api/orders
Route::middleware(['can:get all ratings'])->get('rating', [RatingsAndReviewsController::class, 'getAllRating']); //@get::http://127.0.0.1:8000/api/orders
Route::middleware(['can:get individual rating'])->get('rating/{id}', [RatingsAndReviewsController::class, 'indiviualRating']); //@get::http://127.0.0.1:8000/api/orders/id
Route::middleware(['can:update rating'])->put('rating/{id}', [RatingsAndReviewsController::class, 'updateRating']); //@put::http://127.0.0.1:8000/api/orders/id
Route::middleware(['can:destroy rating'])->delete('rating/{id}', [RatingsAndReviewsController::class, 'destroyRating']); //@delete::http://127.0.0.1:8000/api/orders/id
Route::middleware(['can:average rating'])->get('averagerating/{id}', [RatingsAndReviewsController::class, 'averageRating']); //@get::http://127.0.0.1:8000/api/orders/id
