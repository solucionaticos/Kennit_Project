<?php

use App\Http\Controllers\ApiV1\GetUsersController;
use App\Http\Controllers\ApiV1\Products\DeleteProductController;
use App\Http\Controllers\ApiV1\Products\GetAllProductController;
use App\Http\Controllers\ApiV1\Products\GetOneProductController;
use App\Http\Controllers\ApiV1\Products\RegisterProductController;
use App\Http\Controllers\ApiV1\Products\UpdateProductController;
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

/* Products V2 */
Route::get('/product/get-all', GetAllProductController::class);
Route::get('/product/get-one/{id}', GetOneProductController::class);
Route::post('/product/register', RegisterProductController::class);
Route::put('/product/update/{id}', UpdateProductController::class);
Route::delete('/product/delete/{id}', DeleteProductController::class);
