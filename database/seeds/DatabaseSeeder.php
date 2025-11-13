<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed in correct order to handle foreign key dependencies
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            LocationsTableSeeder::class,
            SettingsTableSeeder::class,
            ListingsTableSeeder::class,
            ProductsTableSeeder::class,
            AddressesTableSeeder::class,
            PostCategoriesTableSeeder::class,
            GroomTipCategoriesTableSeeder::class,
            PostsTableSeeder::class,
            GroomTipsTableSeeder::class,
            PremiumSubscriptionSeeder::class,
        ]);
    }
}
