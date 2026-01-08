<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\WebController@index')->name('web.home');
Route::get('/products', 'App\Http\Controllers\WebController@products')->name('web.products');
Route::get('/product/{slug}', 'App\Http\Controllers\WebController@product')->name('web.product');
Route::get('/contact-us', 'App\Http\Controllers\WebController@contactus')->name('web.contact');
Route::get('/cart', 'App\Http\Controllers\WebController@cart')->name('web.cart');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('web.checkout');
Route::get('/track-order', 'App\Http\Controllers\WebController@trackOrder')->name('track.order');
Route::get('/news', 'App\\Http\\Controllers\\WebController@news')->name('news');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/services', 'App\\Http\\Controllers\\WebController@services')->name('services');

// Blog routes
Route::get('/blog', 'App\Http\Controllers\WebController@blog')->name('blog.index');
Route::get('/blog/{slug}', 'App\Http\Controllers\WebController@blogPost')->name('blog.post');

// Legal pages
Route::get('/terms-and-conditions', 'App\Http\Controllers\WebController@termsAndConditions')->name('terms.conditions');
Route::get('/privacy-policy', 'App\Http\Controllers\WebController@privacyPolicy')->name('privacy.policy');

// Public Reviews page
Route::get('/reviews', [App\Http\Controllers\Web\ReviewController::class, 'index'])->name('web.reviews');

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
        
        // Referrals Management
        Route::get('/referrals', [App\Http\Controllers\AuthController::class, 'referrals'])->name('referrals');
    });
    
    // Admin Routes - Only for admin role
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
        Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
        Route::post('products/filter', 'App\Http\Controllers\Admin\ProductController@filter')->name('products.filter');
        Route::post('products/sortmedia', 'App\Http\Controllers\Admin\ProductController@sortmedia')->name('products.sortmedia');
        Route::post('products/defaultimage', 'App\Http\Controllers\Admin\ProductController@defaultimage')->name('products.defaultimage');
        
        // Product Offers Management
        Route::resource('product-offers', 'App\Http\Controllers\Admin\ProductOfferController');
        Route::post('product-offers/{productOffer}/toggle', 'App\Http\Controllers\Admin\ProductOfferController@toggle')->name('product-offers.toggle');
        
        Route::resource('levels', 'App\Http\Controllers\Admin\LevelController');
        Route::resource('users', 'App\Http\Controllers\Admin\UserController');
        
        Route::resource('news', 'App\Http\Controllers\Admin\NewsController');
        Route::post('news/filter', 'App\Http\Controllers\Admin\NewsController@filter')->name('news.filter');
        Route::resource('suggestions', 'App\Http\Controllers\Admin\SuggustionController');
        Route::resource('posts', 'App\Http\Controllers\Admin\BlogPostController');
        Route::post('posts/filter', 'App\Http\Controllers\Admin\BlogPostController@filter')->name('posts.filter');
        Route::resource('banners', 'App\Http\Controllers\Admin\BannerController');
        Route::post('banners/filter', 'App\Http\Controllers\Admin\BannerController@filter')->name('banners.filter');
        Route::resource('media', 'App\Http\Controllers\Admin\MediaController');
        Route::resource('blog-categories', 'App\Http\Controllers\Admin\BlogCategoryController');
        
        // Courier Services Management
        Route::resource('courier-services', 'App\Http\Controllers\Admin\CourierServiceController');
        Route::patch('courier-services/{courier}/toggle-status', 'App\Http\Controllers\Admin\CourierServiceController@toggleStatus')->name('courier-services.toggle-status');
        Route::post('courier-services/{courier}/test-connection', 'App\Http\Controllers\Admin\CourierServiceController@testConnection')->name('courier-services.test-connection');
        Route::post('courier-services/{courier}/generate-costcenter', 'App\Http\Controllers\Admin\CourierServiceController@generateCostCenter')->name('courier-services.generate-costcenter');
        
        // Team Management Routes
        Route::prefix('teams')->name('teams.')->group(function () {
            Route::get('/', 'App\Http\Controllers\Admin\TeamController@index')->name('index');
            Route::get('/assign', 'App\Http\Controllers\Admin\TeamController@assign')->name('assign');
            Route::post('/assign', 'App\Http\Controllers\Admin\TeamController@storeAssignment')->name('store-assignment');
            Route::delete('/remove/{orderTaker}', 'App\Http\Controllers\Admin\TeamController@removeAssignment')->name('remove-assignment');
            Route::get('/{teamLeader}', 'App\Http\Controllers\Admin\TeamController@show')->name('show');
        });
        
        // Bonus Management Routes
        Route::prefix('bonuses')->name('bonuses.')->group(function () {
            Route::get('/', 'App\Http\Controllers\Admin\TeamController@bonuses')->name('index');
            Route::patch('/{bonus}/status', 'App\Http\Controllers\Admin\TeamController@updateBonusStatus')->name('update-status');
        });
    });
    
    // Routes accessible by admin, order_taker, label_printer, and web_order_taker roles
    Route::middleware('role:admin|order_taker|label_printer|web_order_taker')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('orders', 'App\Http\Controllers\Admin\OrderController');
        
        // Shipments Management
        Route::get('shipments/export', 'App\Http\Controllers\Admin\ShipmentController@exportCsv')->name('shipments.export');
        Route::get('shipments/courier-cities', 'App\Http\Controllers\Admin\ShipmentController@getCities')->name('shipments.courier.cities');
        Route::get('shipments/pickup-addresses', 'App\Http\Controllers\Admin\ShipmentController@getPickupAddresses')->name('shipments.pickup-addresses');
        Route::resource('shipments', 'App\Http\Controllers\Admin\ShipmentController');
        Route::post('shipments/{shipment}/track', 'App\Http\Controllers\Admin\ShipmentController@track')->name('shipments.track');
        Route::post('shipments/{shipment}/cancel', 'App\Http\Controllers\Admin\ShipmentController@cancel')->name('shipments.cancel');
        Route::get('shipments/{shipment}/download-slip', 'App\Http\Controllers\Admin\ShipmentController@downloadSlip')->name('shipments.download-slip');
        
        // Shipments Dashboard
        Route::get('dashboard/shipments', 'App\Http\Controllers\Admin\ShipmentDashboardController@index')->name('dashboard.shipments');
        
        // Order API for shipment creation
        Route::get('orders/{order}/api', 'App\Http\Controllers\Admin\OrderController@apiShow')->name('orders.api.show');
        
        // Team leader self view
        Route::get('teams/my', 'App\Http\Controllers\Admin\TeamController@myTeam')->name('teams.my');
    });

    // Routes accessible by specialist and admin roles
    Route::middleware('role:admin|specialist')->prefix('admin')->name('admin.')->group(function () {
        Route::get('specialist-orders/penalties', 'App\Http\Controllers\Admin\SpecialistOrderController@penalties')->name('specialist-orders.penalties');
        Route::resource('specialist-orders', 'App\Http\Controllers\Admin\SpecialistOrderController');
    });
    
    Route::post('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
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
    $availableCountries = config('app.available_countries', []);
    if (array_key_exists($country, $availableCountries)) {
        session(['country' => $country]);
        // Do NOT change locale when country changes
    }
    return redirect()->back();
})->name('change.country');

Route::get('/change-locale/{locale}', function($locale) {
    $availableLocales = config('app.available_locales', []);
    if (array_key_exists($locale, $availableLocales)) {
        session(['locale' => $locale]);
        // Do NOT change country when locale changes
    }
    return redirect()->back();
})->name('change.locale');

// Debug API endpoint for locale info
Route::get('/api/locale-debug', function() {
    return response()->json([
        'app_locale' => App::getLocale(),
        'session_locale' => session('locale'),
        'session_country' => session('country'),
        'available_locales' => config('app.available_locales'),
        'available_countries' => config('app.available_countries'),
    ]);
});