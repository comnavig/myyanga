<?php

use Illuminate\Database\Seeder;
use App\GroomTipCategory;
use App\User;

class GroomTipCategoriesTableSeeder extends Seeder
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
            ['name' => 'Hair Grooming', 'user_id' => $userId ],
            ['name' => 'Beard Care', 'user_id' => $userId ],
            ['name' => 'Skin Care', 'user_id' => $userId ],
            ['name' => 'Nail Care', 'user_id' => $userId ],
            ['name' => 'Body Care', 'user_id' => $userId ],
            ['name' => 'Style Tips', 'user_id' => $userId ],
        ];

        foreach ($categories as $category) {
            GroomTipCategory::create($category);
        }
    }
}
