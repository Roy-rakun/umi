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
        Schema::table('users', function (Blueprint $table) {
            $table->char('province_id', 2)->nullable()->after('remember_token');
            $table->char('city_id', 4)->nullable()->after('province_id');
            $table->char('district_id', 7)->nullable()->after('city_id');
            $table->char('village_id', 10)->nullable()->after('district_id');
            $table->string('postal_code', 10)->nullable()->after('village_id');
            $table->text('address_detail')->nullable()->after('postal_code');
            
            // Optional: Foreign keys if using constraints (might conflict with seeder if data mismatched)
            // For now, we keep it loose or index it
            $table->index('province_id');
            $table->index('city_id');
            $table->index('district_id');
            $table->index('village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
