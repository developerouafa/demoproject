<?php

use App\Http\Controllers\jwt\apiresourceController;
use App\Http\Controllers\jwt\AuthController;
use App\Http\Controllers\jwt\TestController;
use App\Models\Apiresource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

    //? Api routes

    Route::group(['middlware' => ['api'], 'namespace' => 'jwt'], function(){
        Route::get('/index', [TestController::class, 'index']);
        Route::group(['prefix' => 'admin'], function(){
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/logout', [AuthController::class, 'logout'])->middleware('getadmintoken');
        });
    });
