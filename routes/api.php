<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;


Route::post('urls/create', [UrlController::class, 'create'])->name('short-url.create');
