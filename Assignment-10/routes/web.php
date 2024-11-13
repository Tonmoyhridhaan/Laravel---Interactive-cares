<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UrlController;

Route::get('/{short_url}', [UrlController::class, 'redirectUrl']);
