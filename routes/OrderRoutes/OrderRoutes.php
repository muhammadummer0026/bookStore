<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Protected routes
Route::post('orders', [OrderController::class, 'addOrder']); //@post::http://127.0.0.1:8000/api/orders
Route::get('orders', [OrderController::class, 'getAllOrder']); //@get::http://127.0.0.1:8000/api/orders
Route::get('orders/{id}', [OrderController::class, 'indiviualOrder']); //@get::http://127.0.0.1:8000/api/orders/id
Route::get('orders/search/{status}', [OrderController::class, 'searchOrder']); //@get::http://127.0.0.1:8000/api/orders/search
Route::put('orders/{id}', [OrderController::class, 'updateOrder']); //@put::http://127.0.0.1:8000/api/orders/id
Route::delete('orders/{id}', [OrderController::class, 'destroyOrder']); //@delete::http://127.0.0.1:8000/api/orders/id
