<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product; // Pastikan model Product dibuat nanti

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@thesecret.id',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create Default Affiliate (for testing)
        $affiliateId = 'AFF-' . strtoupper(uniqid());
        $userId = DB::table('users')->insertGetId([
            'name' => 'Sarah Amalia',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'role' => 'affiliate',
            'affiliate_id' => $affiliateId,
            'phone' => '081234567890',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('affiliates')->insert([
            'affiliate_id' => $affiliateId,
            'user_id' => $userId,
            'level' => 'outer',
            'referral_code' => 'sarah-amalia-2024',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Create Dummy Products
        DB::table('products')->insert([
            [
                'product_id' => 'RTR-KLS-KHUSUS-01',
                'name' => 'Spiritual Awakening Masterclass',
                'description' => 'Masterclass to transform your life through sacred knowledge',
                'price' => 599000,
                'commission_inner' => 120000,
                'commission_outer' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'RTR-PROD-TASBIH-01',
                'name' => 'Blessed Tasbih Collection',
                'description' => 'Handcrafted with love and intention for daily remembrance',
                'price' => 497000,
                'commission_inner' => 50000,
                'commission_outer' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'RTR-PROD-SCENT-01',
                'name' => 'Secret Signature Scent',
                'description' => 'A divine fragrance for the soul',
                'price' => 2500000,
                'commission_inner' => 350000,
                'commission_outer' => 350000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        $this->command->info('Database seeded successfully!');
    }
}
