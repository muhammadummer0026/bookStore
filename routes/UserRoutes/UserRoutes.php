<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
// Route::post('resend-verification', [UserController::class, 'verifyEmail'])->name('resend.verification');

// Protected routes
// Route::group(['middleware' => ['auth:api']], function () {
// });

// Route::middleware(['can:get all users'])->get('users', [UserController::class, 'getAllUser']); //@get::http://127.0.0.1:8000/api/users
// Route::middleware(['can:get individual user'])->get('users/{id}', [UserController::class, 'indiviualUser']); //@get::http://127.0.0.1:8000/api/users/id
// Route::middleware(['can:search users'])->get('users/search/{name}', [UserController::class, 'searchUser']); //@get::http://127.0.0.1:8000/api/user/search
// Route::middleware(['can:update user'])->put('users/{id}', [UserController::class, 'updateUser']); //@put::http://127.0.0.1:8000/api/users/id
// Route::middleware(['can:destroy user'])->delete('users/{id}', [UserController::class, 'destroyUser']); //@delete::http://127.0.0.1:8000/api/users/id
// Route::middleware(['can:register user'])->post('register', [UserController::class, 'registerUser']); //@get::http://127.0.0.1:8000/api/register
// Route::middleware(['can:verify email'])->get('/verify/email/{userId}/{token}', [UserController::class, 'verifyEmail'])->name('verify.email'); //@get::http://127.0.0.1:8000/api/verify/email/{userId}/{token}

Route::middleware(['can:get_all_users'])->group(function () {
    Route::get('/users', 'UserController@getAllUser');
});

Route::middleware(['can:get_individual_user'])->group(function () {
    Route::get('/users/{id}', 'UserController@indiviualUser');
});

Route::middleware(['can:search_users'])->group(function () {
    Route::get('/users/search/{name}', 'UserController@searchUser');
});

Route::middleware(['can:update_user'])->group(function () {
    Route::put('/users/{id}', 'UserController@updateUser');
});

use App\Http\Middleware\CheckDestroyUserPermission;

Route::middleware(['can:destroy_user'])->group(function () {
    Route::delete('/users/{id}', [UserController::class, 'destroyUser'])->middleware(CheckDestroyUserPermission::class);
});

Route::middleware(['can:destroy_user'])->group(function () {
    Route::delete('/users/{id}', 'UserController@destroyUser');
});

Route::middleware(['can:register_user'])->group(function () {
    Route::post('/register', 'UserController@registerUser');
});

Route::middleware(['can:verify_email'])->group(function () {
    Route::get('/verify/email/{userId}/{token}', 'UserController@verifyEmail')->name('verify.email');
});
