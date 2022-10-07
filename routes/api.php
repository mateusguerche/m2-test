<?php

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
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
