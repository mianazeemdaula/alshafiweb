<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/login', 'App\Http\Controllers\AuthController@dologin')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
        Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
        Route::resource('levels', 'App\Http\Controllers\Admin\LevelController');
        Route::resource('users', 'App\Http\Controllers\Admin\UserController');
        Route::resource('orders', 'App\Http\Controllers\Admin\OrderController');
        Route::resource('news', 'App\Http\Controllers\Admin\OrderController');
        Route::resource('suggestions', 'App\Http\Controllers\Admin\OrderController');
        Route::resource('posts', 'App\Http\Controllers\Admin\BlogPostController');
    });
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});


Route::get('/send-mail', function () {
    try {
        $order = \App\Models\Order::find(1);
        \Mail::to('mazeemrehan@gmail.com', 'Azeem Rehan')->send(new App\Mail\OrderStatus($order));
        return 'Mail sent successfully';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});