<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CommentController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Define public routes
Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('/posts', PostController::class)->only(['index', 'show']);
Route::apiResource('/products', ProductController::class)->only(['index', 'show']);

// Define protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/categories', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/posts', PostController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/products', ProductController::class)->only(['store', 'update', 'destroy']);

    Route::post('/posts/{postId}/comments', [CommentController::class, 'storeCommentForPost']);
    Route::post('/products/{productId}/comments', [CommentController::class, 'StoreCommentForProduct']);

});