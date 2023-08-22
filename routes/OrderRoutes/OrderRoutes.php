<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Protected routes
// Route::middleware(['can:add order'])->post('orders', [OrderController::class, 'addOrder']); //@post::http://127.0.0.1:8000/api/orders
// Route::middleware(['can:get all orders'])->get('orders', [OrderController::class, 'getAllOrder']); //@get::http://127.0.0.1:8000/api/orders
// Route::middleware(['can:get individual order'])->get('orders/{id}', [OrderController::class, 'indiviualOrder']); //@get::http://127.0.0.1:8000/api/orders/id
// Route::middleware(['can:search orders'])->get('orders/search/{status}', [OrderController::class, 'searchOrder']); //@get::http://127.0.0.1:8000/api/orders/search
// Route::middleware(['can:update order'])->put('orders/{id}', [OrderController::class, 'updateOrder']); //@put::http://127.0.0.1:8000/api/orders/id
// Route::middleware(['can:destroy order'])->delete('orders/{id}', [OrderController::class, 'destroyOrder']); //@delete::http://127.0.0.1:8000/api/orders/id

Route::middleware(['can:add_order'])->group(function () {
    Route::post('/orders', 'OrderController@addOrder');
});

Route::middleware(['can:get_all_orders'])->group(function () {
    Route::get('/orders', 'OrderController@getAllOrder');
});

Route::middleware(['can:get_individual_order'])->group(function () {
    Route::get('/orders/{id}', 'OrderController@indiviualOrder');
});

Route::middleware(['can:search_orders'])->group(function () {
    Route::get('/orders/search/{status}', 'OrderController@searchOrder');
});

Route::middleware(['can:update_order'])->group(function () {
    Route::put('/orders/{id}', 'OrderController@updateOrder');
});

Route::middleware(['can:destroy_order'])->group(function () {
    Route::delete('/orders/{id}', 'OrderController@destroyOrder');
});
