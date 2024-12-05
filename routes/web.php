<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-api', function () {
    return response()->json(['status' => 'API Route Loaded 1']);
});
