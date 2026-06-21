<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test multiple products
$products = App\Models\Product::with('reviews')->take(5)->get();

foreach($products as $product) {
    echo "Product: " . $product->name . "\n";
    echo "Reviews count: " . $product->reviews->count() . "\n";
    echo "Average rating: " . $product->average_rating . "\n";
    echo "Rating accessor: " . $product->rating . "\n";
    
    if($product->reviews->count() > 0) {
        foreach($product->reviews as $review) {
            echo "  - Review rating: " . $review->rating . "\n";
        }
    }
    echo "---\n";
}
