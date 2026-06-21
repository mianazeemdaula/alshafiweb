<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Country;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create some blog categories if they don't exist
        $categories = ['Health', 'Technology', 'Lifestyle', 'Business', 'Travel'];
        
        foreach($categories as $categoryName) {
            BlogCategory::firstOrCreate([
                'slug' => Str::slug($categoryName)
            ], [
                'name' => $categoryName
            ]);
        }

        // Get all countries and categories
        $countries = Country::all();
        $blogCategories = BlogCategory::all();

        // Sample blog posts data
        $blogPosts = [
            ['title' => 'Health Benefits of Natural Products', 'category' => 'Health', 'content' => 'Discover the amazing health benefits of using natural products in your daily routine. From organic skincare to herbal supplements, learn how nature can improve your well-being.'],
            ['title' => 'Latest Technology Trends in E-commerce', 'category' => 'Technology', 'content' => 'Explore the cutting-edge technologies revolutionizing online shopping experiences. From AI recommendations to virtual try-ons, see what\'s shaping the future of retail.'],
            ['title' => 'Sustainable Lifestyle Choices', 'category' => 'Lifestyle', 'content' => 'Learn how to make eco-friendly choices in your daily life. Simple steps towards a sustainable lifestyle that benefits both you and the environment.'],
            ['title' => 'Growing Your Online Business', 'category' => 'Business', 'content' => 'Essential strategies for expanding your online presence and growing your e-commerce business. Tips from successful entrepreneurs and industry experts.'],
            ['title' => 'Travel Essentials for Modern Nomads', 'category' => 'Travel', 'content' => 'Discover the must-have products for digital nomads and frequent travelers. From portable gadgets to travel-friendly accessories.'],
        ];

        foreach($blogPosts as $postData) {
            $category = $blogCategories->where('name', $postData['category'])->first();
            
            // Create post for each country (limited to avoid too many posts)
            foreach($countries->take(3) as $country) {
                BlogPost::create([
                    'user_id' => 1, // Assuming user ID 1 exists
                    'blog_category_id' => $category->id,
                    'country_id' => $country->id,
                    'title' => $postData['title'] . ' in ' . $country->name,
                    'slug' => Str::slug($postData['title'] . ' ' . $country->name),
                    'content' => $postData['content'] . "\n\nThis article is specifically tailored for readers in " . $country->name . ", featuring products and information relevant to this region.",
                    'status' => 'published',
                    'meta_title' => $postData['title'] . ' in ' . $country->name,
                    'meta_description' => substr($postData['content'], 0, 150) . '...',
                ]);
            }
        }
    }
}
