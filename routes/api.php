<?php

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

Route::group(['prefix'=>'paypal'], function () {

    Route::post('/order/{id}/pay', [\App\Http\Controllers\PayPalPaymentsController::class, 'pay'])
        ->name('paypal.pay');

    Route::post('/order/capture/{id}', [\App\Http\Controllers\PayPalPaymentsController::class, 'capture'])
        ->name('paypal.capture');

});

Route::group( [ 'prefix' => 'order-messages' ], function () {
    Route::post('/{id}/message', [\App\Http\Controllers\OrderMessageController::class, 'messagesCreate'])
        ->name('send.message');
    Route::post('/{id}/messages', [\App\Http\Controllers\OrderMessageController::class, 'messagesIndex'])
        ->name('show.messages');
});
