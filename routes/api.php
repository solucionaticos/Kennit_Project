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
Route::resource('products', ProductController::class);
