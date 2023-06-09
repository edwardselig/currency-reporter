<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConverterController;
use App\Http\Controllers\CurrencyQueueController;
use App\Http\Controllers\SignUpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'currencies'], function () {
        Route::get('/list', [CurrencyConverterController::class, 'list']);
        Route::get('/conversions', [CurrencyConverterController::class, 'conversions']);
        Route::get('/timeframe', [CurrencyConverterController::class, 'timeframe']);

        Route::group(['prefix' => 'queue'], function () {
            Route::get('/', [CurrencyQueueController::class, 'index']);
            Route::get('result/{currencyReport:id}', [CurrencyQueueController::class, 'show']);
            Route::post('/', [CurrencyQueueController::class, 'store']);
        });
    });
});

Route::post('/sign-up', [SignUpController::class, 'store']);
