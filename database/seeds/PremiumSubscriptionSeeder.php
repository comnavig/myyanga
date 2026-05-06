<?php

use Illuminate\Database\Seeder;
use App\PremiumSubscription;
use App\User;

class PremiumSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create premium subscriptions for sample users
        $users = User::where('type', '!=', 'admin')->get();

        if ($users->count() > 0) {
            // Create active subscriptions for first 3 users
            foreach ($users->take(3) as $index => $user) {
                $amount = 10000.00; // Base subscription price
                $vat = $amount * 0.075; // 7.5% VAT

                try {
                    PremiumSubscription::create([
                        'user_id' => $user->id,
                        'expiry' => now()->addDays(30),
                        'amount' => $amount,
                        'vat' => $vat,
                        'trans_data' => json_encode([
                            'transaction_id' => 'TXN' . time() . rand(1000, 9999),
                            'payment_method' => 'card',
                            'card_type' => 'visa',
                            'reference' => 'REF' . strtoupper(uniqid()),
                            'gateway' => 'paystack',
                            'paid_at' => now()->toDateTimeString(),
                        ]),
                        'track_id' => 'TRACK' . strtoupper(uniqid()),
                        'status' => 'active',
                    ]);
                } catch (\Exception $e) {
                    echo "[PremiumSubscriptionSeeder] Subscription already exists: " . $user->name . "\n";
                    continue;
                }

                // Create an expired subscription for testing
                if ($users->count() > 3) {
                    $amount = 10000.00;
                    $vat = $amount * 0.075;

                    try {
                        PremiumSubscription::create([
                            'user_id' => $users->get(3)->id,
                            'expiry' => now()->subDays(5), // Expired 5 days ago
                            'amount' => $amount,
                            'vat' => $vat,
                            'trans_data' => json_encode([
                                'transaction_id' => 'TXN' . time() . rand(1000, 9999),
                                'payment_method' => 'card',
                                'card_type' => 'mastercard',
                                'reference' => 'REF' . strtoupper(uniqid()),
                                'gateway' => 'paystack',
                                'paid_at' => now()->subDays(35)->toDateTimeString(),
                            ]),
                            'track_id' => 'TRACK' . strtoupper(uniqid()),
                            'status' => 'expired',
                        ]);
                    } catch (\Exception $e) {
                        echo "[PremiumSubscriptionSeeder] Subscription already exists: " . $users->get(3)->name . "\n";
                        continue;
                    }
                }
            }
        }
    }
}