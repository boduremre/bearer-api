<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiPostController;
use App\Http\Controllers\ApiUserController;

// Herkese Açık Rotalar
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);



// Korumalı Rotalar (Bearer Token Gerektirir)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-password', [ApiAuthController::class, 'update_password']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::post('/logout-all-devices', [ApiAuthController::class, 'logout_all']);

    // Kullanıcı bilgilerini döndüren rota
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Tüm post işlemleri için tek satır yeterli (index, store, show, update, destroy)
    Route::apiResource('posts', ApiPostController::class);

    // Tüm user işlemleri için tek satır yeterli (index, store, show, update, destroy)
    Route::apiResource('/users', ApiUserController::class);
});
