<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\ContentController;
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

// Yetkilendirme ve Rol Yönetimi Rotaları
Route::middleware(['auth:sanctum'])->group(function () {
    // Roller için CRUD
    Route::prefix('roles')->middleware('role:Super Admin')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
        // Rol-İzin ilişkisi için
        Route::post('/{role}/permissions', [RoleController::class, 'syncPermissions']);
        Route::get('/{role}/permissions', [RoleController::class, 'getPermissions']);
    });

    // İzinler için CRUD
    Route::prefix('permissions')->middleware(\App\Http\Middleware\RoleMiddleware::class .':super-admin')->group(function () {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::get('/{permission}', [PermissionController::class, 'show']);
        Route::put('/{permission}', [PermissionController::class, 'update']);
        Route::delete('/{permission}', [PermissionController::class, 'destroy']);
    });

    // Kullanıcı-Rol Yönetimi
    Route::prefix('users')->middleware('role:Super Admin')->group(function () {
        Route::get('/', [UserRoleController::class, 'index']);
        Route::get('/{user}', [UserRoleController::class, 'show']);
        Route::post('/{user}/roles', [UserRoleController::class, 'syncRoles']);
        Route::get('/{user}/roles', [UserRoleController::class, 'getRoles']);
        Route::post('/{user}/permissions', [UserRoleController::class, 'syncPermissions']);
        Route::get('/{user}/permissions', [UserRoleController::class, 'getPermissions']);
    });
}); 

// Contents için API endpoint'leri
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // Tüm içerikleri listele
    Route::get('/contents', [ContentController::class, 'index']);
    
    // Yeni içerik oluştur
    Route::post('/contents', [ContentController::class, 'store']);
    
    // Belirli bir içeriği görüntüle
    Route::get('/contents/{content}', [ContentController::class, 'show']);
    
    // Belirli bir içeriği güncelle
    Route::put('/contents/{content}', [ContentController::class, 'update']);
    
    // Belirli bir içeriği sil
    Route::delete('/contents/{content}', [ContentController::class, 'destroy']);
});

