<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{id}', [UserController::class, 'show']);

Route::put('/users/{id}', [UserController::class, 'update']);

Route::delete('/users/{id}', [UserController::class, 'delete']);

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [LoginController::class, 'login']);
