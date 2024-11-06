<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.apitoken')->group(function () {
    Route::post('/shorten', [UrlController::class, 'shorten']);
    Route::get('/urls', [UrlController::class, 'listUserUrls']);
});