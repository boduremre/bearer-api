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
    // Şifre güncelleme rotası    
    Route::post('/update-password', [ApiAuthController::class, 'update_password']);

    // Tek cihazdan çıkış yapma rotası
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Tüm cihazlardan çıkış yapma rotası
    Route::post('/logout-all-devices', [ApiAuthController::class, 'logout_all']);

    // CSRF Token Göster
    Route::get('/csrf-token', function (Request $request) {
        return ['csrf_token' => $request->cookie('XSRF-TOKEN')];
    });

    // Kullanıcı bilgilerini döndüren rota
    Route::get('/user', function (Request $request) {
        return [
            'bearer_token' => $request->bearerToken(),
            'csrf_token' => $request->cookie('XSRF-TOKEN'),
            'user' => $request->user()
        ];
    });

    // Tüm post işlemleri için tek satır yeterli (index, store, show, update, destroy)
    Route::apiResource('posts', ApiPostController::class);

    // Tüm user işlemleri için tek satır yeterli (index, store, show, update, destroy)
    Route::apiResource('/users', ApiUserController::class);
});
