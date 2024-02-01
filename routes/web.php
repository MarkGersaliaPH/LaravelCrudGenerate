<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestCrudController;
use Illuminate\Support\Facades\Route;
use Markgersaliaph\LaravelCrudGenerate\Http\Controllers\CrudController;

// Route::resource('crud', CrudController::class);

Route::get('/crud', function () {
    return "Asdasdsa";
}); 