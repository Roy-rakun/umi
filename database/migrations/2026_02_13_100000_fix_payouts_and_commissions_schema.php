<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add missing columns to payouts table
        Schema::table('payouts', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('status');
            $table->timestamp('payment_date')->nullable()->after('notes');
        });

        // 2. Add payout_id to commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('payout_id')->nullable()->after('status');
            $table->foreign('payout_id')->references('payout_id')->on('payouts')->onDelete('set null');
        });

        // 3. Modify enum for payouts status (using raw SQL)
        // SQLite doesn't support ALTER COLUMN for enum, so we need to recreate the column
        // For MySQL/MariaDB:
        try {
            DB::statement("ALTER TABLE payouts MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'completed', 'processed') DEFAULT 'pending'");
        } catch (\Exception $e) {
            // Fallback for SQLite - will work with new records
        }

        // 4. Modify enum for commissions status
        try {
            DB::statement("ALTER TABLE commissions MODIFY COLUMN status ENUM('pending', 'approved', 'paid', 'rejected', 'payout_pending') DEFAULT 'pending'");
        } catch (\Exception $e) {
            // Fallback for SQLite
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropForeign(['payout_id']);
            $table->dropColumn('payout_id');
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->dropColumn(['notes', 'payment_date']);
        });
    }
};