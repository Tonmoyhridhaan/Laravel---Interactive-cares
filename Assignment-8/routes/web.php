<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLoggedIn;
use App\Http\Controllers\PostController;


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
   
    Route::get('/profile', function () {
        return view(view: 'profile');
    });
    Route::get('/edit-profile', function () {
        return view(view: 'edit-profile');
    });
    Route::post('/edit-profile', [UserController::class, 'editProfile']);

    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

});