<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OrderDetailController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::post('images/bulk', [ImageController::class, 'bulkStore']);
    Route::post('orders/bulk', [OrderController::class, 'bulkStore']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('addresses', AddressController::class);
    });

    $resources = [
        'categories' => CategoryController::class,
        'images' => ImageController::class,
        'orders' => OrderController::class,
        'orderDetails' => OrderDetailController::class,
        'products' => ProductController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ];

    // Read Permissions
    Route::middleware(['auth:sanctum', 'role:admin,employee,customer'])->group(function () use ($resources) {
        foreach ($resources as $uri => $controller) {
            Route::apiResource($uri, $controller)->only(['index', 'show']);
        }
    });

    // Route::post('roles/store', [RoleController::class, 'store']);
    // Create/Update Permissions
    Route::middleware(['auth:sanctum', 'role:admin,employee'])->group(function () use ($resources) {
        foreach ($resources as $uri => $controller) {
            Route::apiResource($uri, $controller)->only(['store', 'update']);
        }
    });

    // Full Permissions (admin)
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () use ($resources) {
        foreach ($resources as $uri => $controller) {
            Route::apiResource($uri, $controller)->only(['destroy']);
        }
    });
});

