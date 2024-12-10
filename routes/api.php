<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/check-api', fn() => response()->json(['status' => 'API working']));
Route::resource('tasks', TaskController::class);
Route::get('/csrf-token', fn() => response()->json(['csrf_token' => csrf_token()]));
