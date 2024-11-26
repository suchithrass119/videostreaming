<?php

use App\Http\Middleware\PublicSecurity;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\public\VideoManager;


Route::middleware([PublicSecurity::class])->group(function () {
   
    Route::get('/',  [VideoManager::class, 'index']);
    Route::get('/video_details/{id}',  [VideoManager::class, 'VideoDetails']);
});
