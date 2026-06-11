<?php

use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\ConnectionTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('command-center');
});

Route::get('/changelog', [ChangelogController::class, 'index']);
Route::get('/products/quick-create', fn() => view('products.quick-create'));
Route::post('/connections/test', [ConnectionTestController::class, 'test']);
