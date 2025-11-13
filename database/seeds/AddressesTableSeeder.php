<?php

use Illuminate\Database\Seeder;
use App\Address;
use App\User;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('type', '!=', 'admin')->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                Address::create([
                    'user_id' => $user->id,
                    'address' => 'No. ' . rand(1, 100) . ' Sample Street',
                ]);
            }
        }
    }
}
