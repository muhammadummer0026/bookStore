<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$adminRole = Role::create(['name' => 'admin']);
$adminRole = Role::create(['name' => 'user']);

Permission::create(['name' => 'add order']);
Permission::create(['name' => 'get all orders']);
Permission::create(['name' => 'get individual order']);
Permission::create(['name' => 'search orders']);
Permission::create(['name' => 'update order']);
Permission::create(['name' => 'destroy order']);

$adminRole = Role::findByName('admin');
$userRole = Role::findByName('user');

$allPermissions = Permission::all();

$adminRole->syncPermissions($allPermissions);
$userRole->syncPermissions(['add order', 'get all orders', 'get individual order', 'search orders', 'update order', 'destroy order']);

// Protected routes
Route::middleware(['can:add order'])->post('orders', [OrderController::class, 'addOrder']); //@post::http://127.0.0.1:8000/api/orders
Route::middleware(['can:get all orders'])->get('orders', [OrderController::class, 'getAllOrder']); //@get::http://127.0.0.1:8000/api/orders
Route::middleware(['can:get individual order'])->get('orders/{id}', [OrderController::class, 'indiviualOrder']); //@get::http://127.0.0.1:8000/api/orders/id
Route::middleware(['can:search orders'])->get('orders/search/{status}', [OrderController::class, 'searchOrder']); //@get::http://127.0.0.1:8000/api/orders/search
Route::middleware(['can:update order'])->put('orders/{id}', [OrderController::class, 'updateOrder']); //@put::http://127.0.0.1:8000/api/orders/id
Route::middleware(['can:destroy order'])->delete('orders/{id}', [OrderController::class, 'destroyOrder']); //@delete::http://127.0.0.1:8000/api/orders/id
