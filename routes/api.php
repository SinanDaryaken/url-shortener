<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UrlController;
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

Route::prefix('auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post('refresh', 'refresh');
        Route::post('login', 'login');
    });

    Route::post('password/forgot', [ForgotPasswordController::class, 'forgot']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware(['jwt.verify'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::apiResource('urls', UrlController::class)->only('store', 'update', 'destroy');
    Route::controller(UrlController::class)->prefix('urls')->group(function () {
        Route::get('get-by-id/{url}', 'getById');
        Route::get('get-all', 'getAll');
        Route::get('get-filtered', 'getFiltered');
    });
});


