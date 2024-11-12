<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'register');
    Route::post('/auth/login', 'login');

});


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::post('/auth/logout', 'logout');

    });

    Route::controller(TodoController::class)->group(function () {
        Route::get('/todos', 'index');
        Route::get('/todos/{id}', 'show');
        Route::get('/todossearch', 'search');
        Route::post('/todos', 'store');
        Route::put('/todos/{id}', 'update');
        Route::delete('/todos/{id}', 'destroy');
    });

 
});


