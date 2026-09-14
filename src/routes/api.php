<?php

use App\Http\Controllers\TestController;
use App\Modules\Auth\Presentation\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/hola', function () {
    return response()->json([
        'message' => 'Hola mundo',
    ]);
});

Route::middleware('auth.jwt')->group(function () {
    Route::get('/test-auth', [TestController::class, 'test']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
