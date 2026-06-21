<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get all products
        $products = Product::all();
        
        foreach($products as $product) {
            // Create 3-5 reviews per product
            $reviewCount = rand(3, 5);
            for($i = 1; $i <= $reviewCount; $i++) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => 1, // assuming user 1 exists
                    'rating' => rand(3, 5),
                    'comment' => 'Sample review ' . $i . ' for ' . $product->name
                ]);
            }
        }
    }
}
