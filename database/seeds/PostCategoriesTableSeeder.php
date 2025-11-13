<?php

use Illuminate\Database\Seeder;
use App\PostCategory;
use App\User;

class PostCategoriesTableSeeder extends Seeder
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
            ['name' => 'Hair Care Tips', 'user_id' => $userId ],
            ['name' => 'Beauty Trends', 'user_id' => $userId ],
            ['name' => 'Fashion & Style', 'user_id' => $userId ],
            ['name' => 'Makeup Tutorials', 'user_id' => $userId ],
            ['name' => 'Grooming Guide', 'user_id' => $userId ],
            ['name' => 'Skincare Routine', 'user_id' => $userId ],
            ['name' => 'Product Reviews', 'user_id' => $userId ],
            ['name' => 'Celebrity Looks', 'user_id' => $userId ],
        ];

        foreach ($categories as $category) {
            PostCategory::create($category);
        }
    }
}
