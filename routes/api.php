<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\Api\TransactionTypeController;
use App\Http\Controllers\Api\ForecastSimulationController;
use App\Http\Controllers\API\ForecastTransactionController;
use App\Http\Controllers\API\ForecastTransactionIntervalController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//      return $request->user();
//  });


Route::name('api.v1.')->prefix('v1')->group(function () {
    // Route::post('/login', [LoginController::class, 'store'])->name('login');
    // Route::post('/register', [RegisterController::class, 'store'])->name('register');
    Route::middleware('auth:api')->group(function () {
        // Route::get('user', [ProfileController::class, 'index'])->name('user.index');
        // Route::put('user', [ProfileController::class, 'update'])->name('user.update');
    });

    Route::prefix('simplewallet')->middleware('auth:api')->group(function () {
        Route::prefix('user')->group(function () {
            Route::apiResource('transactions', TransactionController::class);
            Route::get('/total', [TransactionController::class, 'total']);
            Route::resource('typetransactions', TransactionTypeController::class);
        });
    });

    // Route::prefix('forecast')->middleware('auth:api')->group(function (){
    Route::prefix('forecast')->group(function (){
        Route::prefix('simulation')->group(function (){
                Route::get('/', [ForecastSimulationController::class, 'index']);
                Route::get('/{id}', [ForecastSimulationController::class, 'detail']);
                Route::post('/', [ForecastSimulationController::class, 'store']);
                Route::put('/{id}', [ForecastSimulationController::class, 'update']);
                Route::delete('/{id}', [ForecastSimulationController::class, 'destroy']);
        });

        Route::prefix('transaction')->group(function (){
                Route::get('/', [ForecastTransactionController::class, 'index']);
                Route::get('/{id}', [ForecastTransactionController::class, 'detail']);
                Route::get('/{id}', [ForecastTransactionController::class, 'show']);
                Route::post('/', [ForecastTransactionController::class, 'store']);
                Route::put('/{id}', [ForecastTransactionController::class, 'update']);
                Route::delete('/{id}', [ForecastTransactionController::class, 'destroy']);
        });

        Route::prefix('interval')->group(function (){
            Route::get('/', [ForecastTransactionIntervalController::class, 'index']);
            Route::post('/', [ForecastTransactionIntervalController::class, 'store']);
            Route::delete('/{id}', [ForecastTransactionIntervalController::class, 'destroy']);
        });
    });

    // Route::middleware('auth:api')->group(function () {
    //      Route::get('user', [ProfileController::class, 'index'])->name('user.index');
    //      Route::patch('user', [ProfileController::class, 'update'])->name('user.update');
    //  });

});
