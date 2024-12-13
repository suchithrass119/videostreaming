<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVideoManager;
use App\Http\Controllers\LoginManager;
use App\Http\Middleware\PublicSecurity;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\public\VideoManager;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Adminsecurity;

Route::middleware([PublicSecurity::class])->group(function () {
   
    Route::get('/',  [VideoManager::class, 'index'])->name('stream.video');
    Route::get('/video_details/{id}',  [VideoManager::class, 'VideoDetails']);
    Route::get('/login',  [LoginManager::class, 'index'])->name('login');
    Route::get('/user-create',  [UserController::class, 'index']);
    Route::get('/videos', [VideoManager::class, 'fetchVideos']);


});

Route::middleware([Adminsecurity::class])->group(function () {

    Route::get('/admin-user-create',  [AdminUserController::class, 'index']);
    Route::get('/video-create',  [AdminVideoManager::class, 'index']);
    Route::post('/video-upload', [AdminVideoManager::class, 'uploadVideo'])->name('upload.video');

});