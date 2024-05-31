<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        Route::put('/admin/users/edit/{id}', [UserController::class, 'editUser']);
        Route::delete('/admin/users/delete/{id}', [UserController::class, 'deleteUser']);
        Route::post('/admin/users/create', [UserController::class, 'storeUser']);
        Route::get('/admin/users', [UserController::class, 'userIndex']);
        Route::get('/admin/users/details/{id}', [UserController::class, 'showUser']);
    });

    Route::get('products', [ProductController::class, 'productIndex']);
    Route::post('products/create', [ProductController::class, 'storeProduct']);
    Route::get('products/details/{id}', [ProductController::class, 'showProduct']);
    Route::put('products/edit/{id}', [ProductController::class, 'editProduct']);
    Route::delete('products/delete/{id}', [ProductController::class, 'deleteProduct']);
});
