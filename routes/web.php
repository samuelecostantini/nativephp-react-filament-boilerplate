<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Models\Brand;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',
    [ HomeController::class, 'index' ]
)->name('home');