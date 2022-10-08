<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CityGroupController;
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
    Route::put('city-groups/{id}', [CityGroupController::class, 'edit']);
    Route::delete('city-groups/{id}/delete', [CityGroupController::class, 'destroy']);

    /* Cidades */
    Route::get('cities', [CityController::class, 'index']);
    Route::post('cities', [CityController::class, 'store']);
    Route::get('cities/{id}', [CityController::class, 'show']);
    Route::put('cities/{id}', [CityController::class, 'edit']);
    Route::delete('cities/{id}/delete', [CityController::class, 'destroy']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
