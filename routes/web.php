<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/login', 'App\Http\Controllers\AuthController@dologin')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
        Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
    });
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
});