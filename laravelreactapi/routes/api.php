<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\ApiAdminMiddleware;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Admin-only routes
Route::middleware(['auth:sanctum', ApiAdminMiddleware::class])->group(function () {
    Route::get('/checkingAuthenticated', function () {
        $role = auth()->user()->role_as == 1 ? 'admin' : 'user';
        return response()->json(['message' => 'Admin access granted', 'status' => 200, 'role' => $role]);
    }); 

    // Category
    Route::post('view-category', [CategoryController::class,'index']);
    Route::post('store-category', [CategoryController::class,'store']);
    Route::post('edit-category/{id}', [CategoryController::class,'edit']);
    Route::put('update-category/{id}', [CategoryController::class,'update']);
    Route::delete('delete-category/{id}', [CategoryController::class,'destroy']);

    // Product
    Route::post('store-product', [ProductController::class,'store']);
    Route::post('/all-category', [CategoryController::class, 'allcategory']);    Route::post('/add-product', [ProductController::class, 'index']);
    Route::post('/view-product', [ProductController::class, 'index']);

});

// Authenticated routes (for all logged-in users, including logout)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});