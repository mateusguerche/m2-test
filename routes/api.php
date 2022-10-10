<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CityGroupController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\ProductController;
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

Route::prefix('v1')->middleware(['auth.token.api'])->group(function () {

    /* Grupos de Cidades */
    Route::get('city-groups', [CityGroupController::class, 'index']);
    Route::post('city-groups', [CityGroupController::class, 'store']);
    Route::get('city-groups/{id}', [CityGroupController::class, 'show']);
    Route::put('city-groups/{id}', [CityGroupController::class, 'update']);
    Route::delete('city-groups/{id}/destroy', [CityGroupController::class, 'destroy']);

    /* Cidades */
    Route::get('cities', [CityController::class, 'index']);
    Route::post('cities', [CityController::class, 'store']);
    Route::get('cities/{id}', [CityController::class, 'show']);
    Route::put('cities/{id}', [CityController::class, 'update']);
    Route::delete('cities/{id}/destroy', [CityController::class, 'destroy']);

    /* Descontos */
    Route::get('discounts', [DiscountController::class, 'index']);
    Route::post('discounts', [DiscountController::class, 'store']);
    Route::get('discounts/{id}', [DiscountController::class, 'show']);
    Route::put('discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('discounts/{id}/destroy', [DiscountController::class, 'destroy']);

    /* Produtos */
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}/destroy', [ProductController::class, 'destroy']);

    /* Campanhas */
    Route::get('campaigns', [CampaignController::class, 'index']);
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::get('campaigns/{id}', [CampaignController::class, 'show']);
    Route::put('campaigns/{id}', [CampaignController::class, 'update']);
    Route::delete('campaigns/{id}/destroy', [CampaignController::class, 'destroy']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
