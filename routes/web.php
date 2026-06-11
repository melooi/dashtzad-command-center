<?php

use App\Http\Controllers\ChangelogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('command-center');
});

Route::get('/changelog', [ChangelogController::class, 'index']);
