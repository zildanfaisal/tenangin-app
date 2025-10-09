<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuaraController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AiTokenController;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Token for Python ASR WebSocket
    Route::get('/ai/token', AiTokenController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Voice endpoints
    Route::post('/suara', [SuaraController::class, 'store']);
    Route::get('/suara/{suara}/status', [SuaraController::class, 'status']);
    Route::post('/suara/{suara}/transcribe', [SuaraController::class, 'transcribe']);

    // Analysis retrieval
    Route::get('/analisis/{analisis}', [AnalisisController::class, 'show']);
    Route::get('/suara/{suara}/analisis', [AnalisisController::class, 'bySuara']);
});