<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [UsersApiController::class, 'index']);
Route::post('/users', [UsersApiController::class, 'store']);
Route::get('/users/{id}', [UsersApiController::class, 'showById']);
Route::put('/users/{id}', [UsersApiController::class, 'update']);
Route::delete('/users/{id}', [UsersApiController::class, 'destroy']);
