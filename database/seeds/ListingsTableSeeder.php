<?php

use Illuminate\Database\Seeder;
use App\Listing;
use App\Category;
use App\Location;
use App\User;
use Illuminate\Support\Str;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $categories = Category::where('parent_id', '!=', '0')->get();
        $locations = Location::where('parent_id', '!=', '0')->get();

        if ($users->count() > 0 && $categories->count() > 0 && $locations->count() > 0) {
            $listings = [
                [
                    'name' => 'Elite Hair Salon',
                    'description' => 'Premium hair salon offering professional styling, coloring, and treatment services.',
                    'cac' => 'yes',
                    'cac_no' => 'RC123456',
                ],
                [
                    'name' => 'Gents Barbing Lounge',
                    'description' => 'Modern barbershop specializing in contemporary and classic cuts for men.',
                    'cac' => 'yes',
                    'cac_no' => 'RC234567',
                ],
                [
                    'name' => 'Glamour Spa & Wellness',
                    'description' => 'Luxury spa offering massages, facials, and body treatments.',
                    'cac' => 'yes',
                    'cac_no' => 'RC345678',
                ],
                [
                    'name' => 'Fashion House Lagos',
                    'description' => 'Boutique offering trendy fashion items and accessories.',
                    'cac' => 'no',
                    'cac_no' => '',
                ],
                [
                    'name' => 'Beauty Paradise',
                    'description' => 'One-stop shop for all your beauty needs including makeup and skincare products.',
                    'cac' => 'yes',
                    'cac_no' => 'RC456789',
                ],
            ];

            foreach ($listings as $listingData) {
                Listing::create([
                    'name' => $listingData['name'],
                    'slug' => Str::slug($listingData['name']),
                    'description' => $listingData['description'],
                    'logo' => 'default-logo.png',
                    'address' => 'Sample Address, ' . $locations->random()->name,
                    'cac' => $listingData['cac'],
                    'cac_no' => $listingData['cac_no'],
                    'parent_id' => $categories->random()->id,
                    'location_id' => $locations->random()->id,
                    'user_id' => $users->random()->id,
                    'status' => 'active',
                    'featured' => rand(0, 1) ? 'yes' : 'no',
                ]);
            }
        }
    }
}
