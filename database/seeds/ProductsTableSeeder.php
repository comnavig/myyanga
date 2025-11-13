<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;
use App\Listing;
use App\User;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $categories = Category::all();
        $listings = Listing::all();

        if ($users->count() > 0 && $categories->count() > 0 && $listings->count() > 0) {
            $products = [
                [
                    'name' => 'Premium Hair Oil',
                    'description' => 'Nourishing hair oil enriched with natural ingredients for healthy, shiny hair.',
                    'tips' => 'Apply to damp hair and massage into scalp. Use 2-3 times weekly for best results.',
                    'price' => 3500.00,
                    'quantity' => '50',
                ],
                [
                    'name' => 'Luxury Face Cream',
                    'description' => 'Anti-aging face cream with SPF 30 protection.',
                    'tips' => 'Apply morning and night on clean face. Avoid contact with eyes.',
                    'price' => 8500.00,
                    'quantity' => '100',
                ],
                [
                    'name' => 'Professional Hair Clippers',
                    'description' => 'Cordless professional-grade clippers for precision cutting.',
                    'tips' => 'Charge fully before first use. Clean blades after each use.',
                    'price' => 25000.00,
                    'quantity' => '30',
                ],
                [
                    'name' => 'Makeup Brush Set',
                    'description' => 'Complete 12-piece professional makeup brush set.',
                    'tips' => 'Clean brushes weekly with mild soap. Store in dry place.',
                    'price' => 12000.00,
                    'quantity' => '75',
                ],
                [
                    'name' => 'Organic Body Lotion',
                    'description' => 'Moisturizing body lotion with shea butter and vitamin E.',
                    'tips' => 'Apply to body after shower for best absorption.',
                    'price' => 4500.00,
                    'quantity' => '120',
                ],
                [
                    'name' => 'Hair Relaxer Kit',
                    'description' => 'Professional hair relaxer with conditioner included.',
                    'tips' => 'Follow instructions carefully. Do a patch test first.',
                    'price' => 6500.00,
                    'quantity' => '60',
                ],
                [
                    'name' => 'Beard Growth Oil',
                    'description' => 'Natural beard oil promoting growth and softness.',
                    'tips' => 'Apply daily to beard and massage well.',
                    'price' => 4000.00,
                    'quantity' => '80',
                ],
                [
                    'name' => 'Nail Polish Set',
                    'description' => 'Set of 10 vibrant nail polish colors.',
                    'tips' => 'Apply base coat first, then 2 coats of color, finish with top coat.',
                    'price' => 5500.00,
                    'quantity' => '90',
                ],
            ];

            foreach ($products as $productData) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'tips' => $productData['tips'],
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                    'category_id' => $categories->random()->id,
                    'listing_id' => $listings->random()->id,
                    'user_id' => $users->random()->id,
                    'featured' => rand(0, 1),
                    'status' => 'active',
                ]);
            }
        }
    }
}
