<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$adminRole = Role::create(['name' => 'admin']);
$adminRole = Role::create(['name' => 'user']);

Permission::create(['name' => 'get all users']);
Permission::create(['name' => 'get individual user']);
Permission::create(['name' => 'search users']);
Permission::create(['name' => 'update user']);
Permission::create(['name' => 'destroy user']);
Permission::create(['name' => 'register user']);
Permission::create(['name' => 'verify email']);

$adminRole = Role::findByName('admin');
$userRole = Role::findByName('user');

$allPermissions = Permission::all();

$adminRole->syncPermissions($allPermissions);
$userRole->syncPermissions(['register user', 'verify email']);

// Public routes
// Route::post('resend-verification', [UserController::class, 'verifyEmail'])->name('resend.verification');

// Protected routes
// Route::group(['middleware' => ['auth:api']], function () {
// });

Route::middleware(['can:get all users'])->get('users', [UserController::class, 'getAllUser']); //@get::http://127.0.0.1:8000/api/users
Route::middleware(['can:get individual user'])->get('users/{id}', [UserController::class, 'indiviualUser']); //@get::http://127.0.0.1:8000/api/users/id
Route::middleware(['can:search users'])->get('users/search/{name}', [UserController::class, 'searchUser']); //@get::http://127.0.0.1:8000/api/user/search
Route::middleware(['can:update user'])->put('users/{id}', [UserController::class, 'updateUser']); //@put::http://127.0.0.1:8000/api/users/id
Route::middleware(['can:destroy user'])->delete('users/{id}', [UserController::class, 'destroyUser']); //@delete::http://127.0.0.1:8000/api/users/id
Route::middleware(['can:register user'])->post('register', [UserController::class, 'registerUser']); //@get::http://127.0.0.1:8000/api/register
Route::middleware(['can:verify email'])->get('/verify/email/{userId}/{token}', [UserController::class, 'verifyEmail'])->name('verify.email'); //@get::http://127.0.0.1:8000/api/verify/email/{userId}/{token}
