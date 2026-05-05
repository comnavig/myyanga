<?php

use Illuminate\Database\Seeder;
use App\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['name' => 'site_name', 'value' => 'MyYanga'],
            ['name' => 'site_email', 'value' => 'info@myyanga.com'],
            ['name' => 'site_phone', 'value' => '+234 800 000 0000'],
            ['name' => 'currency', 'value' => 'NGN'],
            ['name' => 'currency_symbol', 'value' => '₦'],
            ['name' => 'vat_percentage', 'value' => '7.5'],
            ['name' => 'premium_price', 'value' => '10000'],
            ['name' => 'premium_duration_days', 'value' => '30'],
            ['name' => 'featured_listing_price', 'value' => '5000'],
            ['name' => 'featured_product_price', 'value' => '3000'],
            ['name' => 'shipping_fee', 'value' => '2000'],
            ['name' => 'facebook_url', 'value' => 'https://facebook.com/myyanga'],
            ['name' => 'twitter_url', 'value' => 'https://twitter.com/myyanga'],
            ['name' => 'instagram_url', 'value' => 'https://instagram.com/myyanga'],
            ['name' => 'logo', 'value' => '/assets/img/logo.svg'],
            ['name' => 'about_us', 'value' => 'MyYanga is your premier destination for beauty and fashion services.'],
        ];

        foreach ($settings as $setting) {
            Settings::create($setting);
        }
    }
}
