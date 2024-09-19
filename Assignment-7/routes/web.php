<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLoggedIn;


Route::get('/registration', function () {
    return view('registration');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/test', function () {
    dd(session()->all());
});

Route::middleware([isLoggedIn::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/profile', function () {
        return view(view: 'profile');
    });
    Route::get('/edit-profile', function () {
        return view(view: 'edit-profile');
    });
    Route::post('/edit-profile', [UserController::class, 'editProfile']);

    Route::get('/logout', [UserController::class, 'logout']);
    

});