<?php

use Illuminate\Database\Seeder;
use App\GroomTips;
use App\GroomTipCategory;
use App\User;
use Illuminate\Support\Str;

class GroomTipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $categories = GroomTipCategory::all();

        if ($users->count() > 0 && $categories->count() > 0) {
            $tips = [
                [
                    'name' => 'Essential Beard Grooming Tips',
                    'description' => 'A well-groomed beard requires regular maintenance. Learn how to trim, shape, and condition your beard properly. Use quality beard oils and balms to keep your beard soft and manageable. Regular trimming helps maintain shape and prevents split ends.',
                ],
                [
                    'name' => 'Hair Styling Guide for Men',
                    'description' => 'Master the art of styling your hair with these professional tips and product recommendations. Choose the right products for your hair type and learn techniques that work best for your desired look. From pomades to waxes, understand what works for you.',
                ],
                [
                    'name' => 'Skin Care Routine for Men',
                    'description' => 'Good skin care isn\'t just for women. Here\'s a simple yet effective routine every man should follow. Start with a good cleanser, use a moisturizer daily, and don\'t forget sunscreen. Exfoliate weekly for best results.',
                ],
                [
                    'name' => 'How to Maintain Fresh Haircut',
                    'description' => 'Keep your haircut looking fresh between barbershop visits with these maintenance tips. Regular washing, proper styling, and touch-ups at home can extend the life of your haircut. Know when it\'s time to visit your barber again.',
                ],
                [
                    'name' => 'Perfect Shaving Techniques',
                    'description' => 'Achieve a close, comfortable shave every time with these expert techniques. Prep your skin properly, use quality razors, and follow up with aftershave. Learn how to prevent razor burn and ingrown hairs.',
                ],
                [
                    'name' => 'Nail Care for Men',
                    'description' => 'Well-groomed nails are a sign of good personal hygiene. Learn how to properly trim, file, and maintain your nails. Keep cuticles healthy and prevent common nail problems with these simple tips.',
                ],
            ];

            foreach ($tips as $tipData) {
                GroomTips::create([
                    'name' => $tipData['name'],
                    'slug' => Str::slug($tipData['name']),
                    'description' => $tipData['description'],
                    'category_id' => $categories->random()->id,
                    'user_id' => $users->random()->id,
                    'status' => 'published',
                ]);
            }
        }
    }
}
