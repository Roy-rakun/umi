<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. PRODUCTS
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->primary(); // RTR-KLS-KHUSUS-01
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('promo_price', 12, 2)->nullable();
            $table->decimal('commission_inner', 12, 2)->default(0);
            $table->decimal('commission_outer', 12, 2)->default(0);
            $table->timestamps();
        });

        // 2. AFFILIATES
        Schema::create('affiliates', function (Blueprint $table) {
            $table->string('affiliate_id')->primary(); // AFF-001
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('level', ['inner', 'outer'])->default('outer');
            $table->decimal('total_commission', 15, 2)->default(0);
            $table->decimal('total_payout', 15, 2)->default(0);
            $table->string('referral_code')->unique()->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });

        // 3. AFFILIATE LINKS
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->string('affiliate_id');
            $table->foreign('affiliate_id')->references('affiliate_id')->on('affiliates')->onDelete('cascade');
            $table->string('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->string('tracking_code')->unique();
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->timestamps();
        });

        // 4. ORDERS
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary(); // ORD-2024-001
            $table->string('product_id');
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->string('affiliate_ref')->nullable();
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('ip_address')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->string('affiliate_id')->nullable(); // Denormalization for easy query
            $table->timestamps();
        });
        
        // 5. COMMISSIONS
        Schema::create('commissions', function (Blueprint $table) {
            $table->string('commission_id')->primary(); // COM-001
            $table->string('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->string('affiliate_id');
            $table->foreign('affiliate_id')->references('affiliate_id')->on('affiliates')->onDelete('cascade');
            $table->string('product_id');
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->decimal('commission_amount', 12, 2);
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        // 6. PAYOUTS
        Schema::create('payouts', function (Blueprint $table) {
            $table->string('payout_id')->primary();
            $table->string('affiliate_id');
            $table->foreign('affiliate_id')->references('affiliate_id')->on('affiliates');
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending', 'processed'])->default('pending');
            $table->date('payout_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });

        // 7. FRAUD LOGS
        Schema::create('fraud_logs', function (Blueprint $table) {
            $table->id();
            $table->string('affiliate_id');
            $table->foreign('affiliate_id')->references('affiliate_id')->on('affiliates');
            $table->string('order_id')->nullable();
            $table->string('fraud_type'); // self_order, fake_traffic
            $table->json('evidence_data')->nullable();
            $table->string('action_taken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraud_logs');
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('commissions');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('affiliate_links');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('products');
    }
};
