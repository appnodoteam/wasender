<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(["prefix"=> "v2"], function(){
    Route::apiResource("numbers", \App\Http\Controllers\V1\Api\NumberController::class);

    Route::post("send-text", [\App\Http\Controllers\V1\Api\SendMessagesController::class, "sendText"]);
    Route::post("send-template", [\App\Http\Controllers\V1\Api\SendMessagesController::class, "sendTemplate"]);
    Route::post("send-document", [\App\Http\Controllers\V1\Api\SendMessagesController::class, "sendDocument"]);
    Route::post("send-document-link", [\App\Http\Controllers\V1\Api\SendMessagesController::class, "sendDocumentLink"]);
    Route::post("send-otp", [\App\Http\Controllers\V1\Api\SendMessagesController::class, "sendOTP"]);
});
