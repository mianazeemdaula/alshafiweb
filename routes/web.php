<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('login', function () {
    return view('auth.signin');
});

Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::group(['prefix' => 'admin', 'use' => 'admin.'], function () {
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
    });
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
});