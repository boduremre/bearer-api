<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(
        [
            'api_version' => '1.0.0',
            'app_name' => 'My Bearer API',
            'developer' => 'Emre Bodur',
            'documentation' => 'https://api.example.com/docs',
            'contact' => 'https://api.example.com/contact',
            'support' => 'https://api.example.com/support',
            'terms_of_service' => 'https://api.example.com/terms',
            'privacy_policy' => 'https://api.example.com/privacy',
            'license' => 'MIT License',
            'message' => 'Welcome to the API',
            'status' => 'API is running',
            'server_timestamp' => now()->toDateTimeString()
        ]
    );
});
