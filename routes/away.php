<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('{slug}', [RedirectController::class, 'redirect'])->fallback();
