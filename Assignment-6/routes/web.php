<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'home']);
Route::get('/experiences', [PortfolioController::class, 'experience']);
Route::get('/projects', [PortfolioController::class, 'projects']);
Route::get('/project-single/{id}', [PortfolioController::class, 'projectSingle']);



