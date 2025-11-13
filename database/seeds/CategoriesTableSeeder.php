<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\User;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('type', 'admin')->first();
        $userId = $admin ? $admin->id : 1;

        $categories = [
            ['name' => 'Hair & Beauty', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Barbershop', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Hair Salon', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Spa & Wellness', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Makeup Artist', 'parent_id' => '1', 'user_id' => $userId],

            ['name' => 'Fashion & Clothing', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Men\'s Fashion', 'parent_id' => '6', 'user_id' => $userId],
            ['name' => 'Women\'s Fashion', 'parent_id' => '6', 'user_id' => $userId],
            ['name' => 'Children\'s Fashion', 'parent_id' => '6', 'user_id' => $userId],
            ['name' => 'Accessories', 'parent_id' => '6', 'user_id' => $userId],

            ['name' => 'Beauty Products', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Skincare', 'parent_id' => '11', 'user_id' => $userId],
            ['name' => 'Haircare', 'parent_id' => '11', 'user_id' => $userId],
            ['name' => 'Cosmetics', 'parent_id' => '11', 'user_id' => $userId],
            ['name' => 'Fragrances', 'parent_id' => '11', 'user_id' => $userId],

            ['name' => 'Services', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Grooming', 'parent_id' => '16', 'user_id' => $userId],
            ['name' => 'Styling', 'parent_id' => '16', 'user_id' => $userId],
            ['name' => 'Photography', 'parent_id' => '16', 'user_id' => $userId],
            ['name' => 'Events', 'parent_id' => '16', 'user_id' => $userId],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
