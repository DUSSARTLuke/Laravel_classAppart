<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

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


// Route::resource('products', ProductController::class);


//Public route
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/inscription', [AuthController::class, 'inscription']);
Route::post('/connexion', [AuthController::class, 'connexion']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);

// Protection des routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/deconnexion', [AuthController::class, 'deconnexion']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
