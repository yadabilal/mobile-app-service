<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\VerificationController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('verification', [VerificationController::class, 'verify']);

Route::group(['prefix' => 'subscription'], function () {
    Route::post('purchase', [SubscriptionController::class, 'purchase']);
    Route::post('check', [SubscriptionController::class, 'check']);
});

