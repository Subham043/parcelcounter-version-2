<?php

namespace Database\Seeders;

use App\Features\PaymentOptions\Models\PaymentOption;
use Illuminate\Database\Seeder;

class PaymentOptionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PaymentOption::create(['name' => "Cash On Delivery", 'slug' => "Cash On Delivery", 'description' => 'Pay with cash upon delivery', 'is_active' => true, 'user_id' => 1]);
        PaymentOption::create(['name' => "Phonepe", 'slug' => "Online - Phonepe", 'description' => 'After clicking “ Place Order ”, you will be redirected to Phonepe (Cards, UPI, NetBanking, Wallets) to complete your purchase securely', 'is_active' => true, 'user_id' => 1]);
        PaymentOption::create(['name' => "Razorpay - UPI", 'slug' => "Online - Razorpay", 'description' => 'After clicking “ Place Order ”, you will be redirected to Razorpay (UPI, Wallets) to complete your purchase securely', 'is_active' => true, 'user_id' => 1]);
        PaymentOption::create(['name' => "PayU", 'slug' => "Online - PayU", 'description' => 'After clicking “ Place Order ”, you will be redirected to PayU (Cards, UPI, NetBanking, Wallets) to complete your purchase securely', 'is_active' => true, 'user_id' => 1]);
        PaymentOption::create(['name' => "CashFree", 'slug' => "Online - CashFree", 'description' => 'After clicking “ Place Order ”, you will be redirected to CashFree (Cards, UPI, NetBanking, Wallets) to complete your purchase securely', 'is_active' => true, 'user_id' => 1]);
    }
}
