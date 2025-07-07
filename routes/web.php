<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\WebController@index')->name('web.home');
Route::get('/products', 'App\Http\Controllers\WebController@products')->name('web.products');
Route::get('/contact-us', 'App\Http\Controllers\WebController@contactus')->name('web.contact');
Route::get('/cart', 'App\Http\Controllers\WebController@cart')->name('web.cart');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('web.checkout');
Route::get('/track-order', 'App\Http\Controllers\WebController@trackOrder')->name('track.order');
Route::get('/news', 'App\\Http\\Controllers\\WebController@news')->name('news');
Route::get('/categories', 'App\\Http\\Controllers\\WebController@categories')->name('categories');
Route::get('/services', 'App\\Http\\Controllers\\WebController@services')->name('services');

// Blog routes
Route::get('/blog', 'App\Http\Controllers\WebController@blog')->name('blog.index');
Route::get('/blog/{slug}', 'App\Http\Controllers\WebController@blogPost')->name('blog.post');

// Cart routes
Route::post('/cart/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::post('/cart/update', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::delete('/cart/remove', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
Route::get('/cart/contents', 'App\Http\Controllers\CartController@contents')->name('cart.contents');
Route::delete('/cart/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');

// Checkout routes
Route::post('/checkout/place-order', 'App\Http\Controllers\CheckoutController@placeOrder')->name('checkout.place-order');
Route::get('/order-confirmation/{orderId}', 'App\Http\Controllers\CheckoutController@orderConfirmation')->name('order.confirmation');

Route::get('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/login', 'App\Http\Controllers\AuthController@dologin')->name('login');
Route::get('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/register', 'App\Http\Controllers\AuthController@doregister')->name('register');


Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'App\Http\Controllers\AuthController@dashboard')->name('dashboard');
    
    // User Backend Routes (protected by auth and role:user middleware)
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', 'App\Http\Controllers\User\DashboardController@index')->name('dashboard');
        
        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'App\Http\Controllers\User\ProfileController@show')->name('show');
            Route::get('/edit', 'App\Http\Controllers\User\ProfileController@edit')->name('edit');
            Route::put('/update', 'App\Http\Controllers\User\ProfileController@update')->name('update');
            Route::get('/change-password', 'App\Http\Controllers\User\ProfileController@changePassword')->name('change-password');
            Route::put('/update-password', 'App\Http\Controllers\User\ProfileController@updatePassword')->name('update-password');
        });
        
        // Order Management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'App\Http\Controllers\User\OrderController@index')->name('index');
            Route::get('/{order}', 'App\Http\Controllers\User\OrderController@show')->name('show');
            Route::get('/{order}/track', 'App\Http\Controllers\User\OrderController@track')->name('track');
            Route::put('/{order}/cancel', 'App\Http\Controllers\User\OrderController@cancel')->name('cancel');
        });
        
        // Review Management
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', 'App\Http\Controllers\User\ReviewController@index')->name('index');
            Route::get('/create', 'App\Http\Controllers\User\ReviewController@create')->name('create');
            Route::post('/', 'App\Http\Controllers\User\ReviewController@store')->name('store');
            Route::get('/{review}/edit', 'App\Http\Controllers\User\ReviewController@edit')->name('edit');
            Route::put('/{review}', 'App\Http\Controllers\User\ReviewController@update')->name('update');
            Route::delete('/{review}', 'App\Http\Controllers\User\ReviewController@destroy')->name('destroy');
        });
    });
    
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
        Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
        Route::post('products/filter', 'App\Http\Controllers\Admin\ProductController@filter')->name('products.filter');
        Route::post('products/sortmedia', 'App\Http\Controllers\Admin\ProductController@sortmedia')->name('products.sortmedia');
        Route::post('products/defaultimage', 'App\Http\Controllers\Admin\ProductController@defaultimage')->name('products.defaultimage');
        // 
        Route::resource('levels', 'App\Http\Controllers\Admin\LevelController');
        Route::resource('users', 'App\Http\Controllers\Admin\UserController');
        Route::resource('orders', 'App\Http\Controllers\Admin\OrderController');
        Route::resource('news', 'App\Http\Controllers\Admin\NewsController');
        Route::post('news/filter', 'App\Http\Controllers\Admin\NewsController@filter')->name('news.filter');
        Route::resource('suggestions', 'App\Http\Controllers\Admin\SuggustionController');
        Route::resource('posts', 'App\Http\Controllers\Admin\BlogPostController');
        Route::post('posts/filter', 'App\Http\Controllers\Admin\BlogPostController@filter')->name('posts.filter');
        Route::resource('banners', 'App\Http\Controllers\Admin\BannerController');
        Route::post('banners/filter', 'App\Http\Controllers\Admin\BannerController@filter')->name('banners.filter');
        Route::resource('media', 'App\Http\Controllers\Admin\BlogPostController');
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

Route::get('/change-country/{country}', function($country) {
    session(['country' => $country]);
    return redirect()->back();
})->name('change.country');

Route::get('/change-locale/{locale}', function($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
})->name('change.locale');