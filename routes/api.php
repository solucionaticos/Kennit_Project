<?php

use App\Http\Controllers\ApiV1\GetUsersController;
use App\Http\Controllers\ApiV1\ProductController;
use App\Http\Controllers\ApiV1\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Users */
Route::post('/user/create', RegisterUserController::class);
Route::get('/user/get-all', GetUsersController::class);

/* Products */
Route::get('/product/get-all', [ProductController::class, 'getAll'])->name('product.get-all');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
