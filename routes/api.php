<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\TypeMetaController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::options('{any}', function () {
    return response()->json([], 204);
})->where('any', '.*');

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
    $superAdmin = RoleMiddleware::class.':super-admin';

    // Roller için CRUD
    Route::prefix('roles')->middleware($superAdmin)->group(function () {
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
    Route::prefix('permissions')->middleware($superAdmin)->group(function () {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::get('/{permission}', [PermissionController::class, 'show']);
        Route::put('/{permission}', [PermissionController::class, 'update']);
        Route::delete('/{permission}', [PermissionController::class, 'destroy']);
    });

    // Kullanıcı-Rol Yönetimi
    Route::prefix('users')->middleware($superAdmin)->group(function () {
        Route::get('/', [UserRoleController::class, 'index']);
        Route::get('/{user}', [UserRoleController::class, 'show']);
        Route::post('/{user}/roles', [UserRoleController::class, 'syncRoles']);
        Route::get('/{user}/roles', [UserRoleController::class, 'getRoles']);
        Route::post('/{user}/permissions', [UserRoleController::class, 'syncPermissions']);
        Route::get('/{user}/permissions', [UserRoleController::class, 'getPermissions']);
    });
}); 

// Contents, Types ve TypeMetas için API endpoint'leri
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // Contents rotaları
    Route::resource('contents', ContentController::class);

    Route::get('contents/type/{type}', [ContentController::class, 'getContentsByType']);


    
    // Types rotaları
    Route::resource('types', TypeController::class);
    
    // Type Meta'lar için CRUD işlemleri
    Route::prefix('types/{type}')
    ->group(function () {
        Route::resource('metas', TypeMetaController::class)
            ->parameters(['metas' => 'typeMeta']);
    });
    
});

