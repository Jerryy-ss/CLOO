<?php

use Illuminate\Support\Facades\Route;
use Kreait\Laravel\Firebase\Facades\Firebase;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\FirebaseController;

Route::get('/test-firebase', [FirebaseController::class, 'index']);

