<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    //? Api routes
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
