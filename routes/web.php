<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\LoginManager;
use App\Http\Middleware\PublicSecurity;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\public\VideoManager;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Adminsecurity;

Route::middleware([PublicSecurity::class])->group(function () {
   
    Route::get('/',  [VideoManager::class, 'index']);
    Route::get('/video_details/{id}',  [VideoManager::class, 'VideoDetails']);
    Route::get('/login',  [LoginManager::class, 'index'])->name('login');
    Route::get('/user-create',  [UserController::class, 'index']);

});

Route::middleware([Adminsecurity::class])->group(function () {

    Route::get('/admin-user-create',  [AdminUserController::class, 'index']);
});