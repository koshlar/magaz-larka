<?php

use App\Http\Controllers\RegLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});
Route::get('/catalog', function () {
  return view('catalog');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', function () {
    return view('reglog.login');
  })->name('login');
  Route::post('/login', [RegLogController::class, 'login']);

  Route::get('/register', function () {
    return view('reglog.register');
  });
  Route::post('/register', [RegLogController::class, 'register']);
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [RegLogController::class, 'logout']);
});
