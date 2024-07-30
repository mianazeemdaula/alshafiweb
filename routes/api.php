<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
Route::post('/signup-mobile', 'App\Http\Controllers\Api\AuthController@signupUsingMobile');
Route::post('/auth/is-mobile-register', 'App\Http\Controllers\Api\AuthController@isMobileRegister');

Route::get('/categories', 'App\Http\Controllers\Api\CategoryController@index');
Route::get('/products/featured', 'App\Http\Controllers\Api\ProductController@featured');
Route::get('/products', 'App\Http\Controllers\Api\ProductController@index');


Route::get('/states', 'App\Http\Controllers\Api\StateController@index');
Route::get('/cities', 'App\Http\Controllers\Api\CityController@index');
Route::get('/payment-methods', 'App\Http\Controllers\Api\PaymentMethodController@index');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/orders', 'App\Http\Controllers\Api\OrderController');

    Route::post('/suggestions', 'App\Http\Controllers\Api\SuggestionController@store');
});