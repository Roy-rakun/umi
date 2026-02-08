<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Spiritual Awakening Masterclass (Digital)
        Product::updateOrCreate(
            ['product_id' => 'MST-001'],
            [
                'name' => 'Spiritual Awakening Masterclass',
                'price' => 497000,
                'category' => 'Online Class',
                'type' => 'digital',
                'description' => 'Transform your life through sacred knowledge. A comprehensive guide to inner peace.',
                'commission_inner' => 50000,
                'commission_outer' => 30000,
            ]
        );

        // 2. Secret Signature Scent (Physical)
        Product::updateOrCreate(
            ['product_id' => 'PFM-001'],
            [
                'name' => 'Secret Signature Scent',
                'price' => 599000,
                'category' => 'Perfume',
                'type' => 'physical',
                'weight' => 200, // 200 grams
                'description' => 'A divine fragrance for the soul. Hand-mixed with spiritual intention.',
                'commission_inner' => 60000,
                'commission_outer' => 40000,
            ]
        );

        // 3. Blessed Tasbih Collection (Physical)
        Product::updateOrCreate(
            ['product_id' => 'TSB-001'],
            [
                'name' => 'Blessed Tasbih Collection',
                'price' => 299000,
                'category' => 'Spiritual Products',
                'type' => 'physical',
                'weight' => 100,
                'description' => 'Handcrafted with love and intention for daily remembrance.',
                'commission_inner' => 30000,
                'commission_outer' => 20000,
            ]
        );

        // 4. Sacred Gathering 2026 (Physical - Ticket/Event Kit)
        Product::updateOrCreate(
            ['product_id' => 'EVT-001'],
            [
                'name' => 'Sacred Gathering 2026',
                'price' => 2500000,
                'category' => 'Events',
                'type' => 'physical', // Assuming physical kit sent or just to test physical flow
                'weight' => 500,
                'description' => 'Join our transformative retreat. Experience the secret in person.',
                'commission_inner' => 250000,
                'commission_outer' => 150000,
            ]
        );
    }
}
