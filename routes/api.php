<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::middleware('throttle:6,1')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
    });
}); 

// Permission, Role ve User Role routes - sadece super-admin erişebilir
Route::middleware(['auth:sanctum', 'super-admin'])->group(function () {
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('roles', RoleController::class);
    
    Route::prefix('user-roles')->group(function () {
        Route::get('/', [UserRoleController::class, 'index']);
        Route::post('/', [UserRoleController::class, 'store']);
        Route::get('/{user}', [UserRoleController::class, 'show']);
        Route::put('/{user}', [UserRoleController::class, 'update']);
        Route::delete('/{user}', [UserRoleController::class, 'destroy']);
    });
}); 