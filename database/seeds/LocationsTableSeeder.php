<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\User;

class LocationsTableSeeder extends Seeder
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

        $locations = [
            // States (parent_id = 0)
            ['name' => 'Lagos', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Abuja', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Port Harcourt', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Kano', 'parent_id' => '0', 'user_id' => $userId],
            ['name' => 'Ibadan', 'parent_id' => '0', 'user_id' => $userId],

            // Lagos areas (parent_id = 1 for Lagos)
            ['name' => 'Ikeja', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Victoria Island', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Lekki', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Surulere', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Yaba', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Ajah', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Maryland', 'parent_id' => '1', 'user_id' => $userId],
            ['name' => 'Ikoyi', 'parent_id' => '1', 'user_id' => $userId],

            // Abuja areas (parent_id = 2 for Abuja)
            ['name' => 'Garki', 'parent_id' => '2', 'user_id' => $userId],
            ['name' => 'Wuse', 'parent_id' => '2', 'user_id' => $userId],
            ['name' => 'Maitama', 'parent_id' => '2', 'user_id' => $userId],
            ['name' => 'Asokoro', 'parent_id' => '2', 'user_id' => $userId],
            ['name' => 'Gwarinpa', 'parent_id' => '2', 'user_id' => $userId],
        ];

        foreach ($locations as $location) {
            try {
                Location::create($location);
            } catch (\Exception $e) {
                echo "[LocationsTableSeeder] Location already exists: " . $location['name'] . "\n";
                continue;
            }
        }
    }
}
