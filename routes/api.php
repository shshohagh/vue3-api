<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\ReviewApiController;
use App\Http\Controllers\ApiController;

// Open Routes
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

// Protected Routes
Route::group([
    "middleware" => ["auth:api"]
], function(){

    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
});

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api'); */

/* users */
Route::get('/users', [UsersApiController::class, 'index']);
Route::post('/users', [UsersApiController::class, 'store']);
Route::get('/users/{id}', [UsersApiController::class, 'showById']);
Route::put('/users/{id}', [UsersApiController::class, 'update']);
Route::delete('/users/{id}', [UsersApiController::class, 'destroy']);
/* products */
Route::get('/products', [ProductApiController::class, 'index']);
Route::post('/products', [ProductApiController::class, 'store']);
Route::get('/products/{id}', [ProductApiController::class, 'showById']);
Route::put('/products/{id}', [ProductApiController::class, 'update']);
Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
/* reviews */
//Route::get('/products/reviews', [ReviewApiController::class, 'index']);
Route::post('/products/reviews', [ReviewApiController::class, 'store']);
Route::get('/products/reviews/{id}', [ReviewApiController::class, 'showById']);
Route::put('/products/reviews/{id}', [ReviewApiController::class, 'update']);
Route::delete('/products/reviews/{id}', [ReviewApiController::class, 'destroy']);
