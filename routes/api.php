<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TravelController;

Route::middleware('api')->group( function(){
    Route::post('/login',[UserLoginController::class ,'login']);
    Route::get('/list',[UserController::class ,'list']);
    Route::post('/create',[UserController::class ,'create']);
    Route::put('/update/{id}',[UserController::class ,'update']);
    Route::delete('/remove/{id}',[UserController::class ,'remove']);



    Route::get('/travel/list',[TravelController::class ,'list']);
    Route::post('/travel/create',[TravelController::class ,'create']);
    Route::put('/travel/update/{id}',[TravelController::class ,'update']);
    Route::delete('/travel/remove/{id}',[TravelController::class ,'remove']);
});
