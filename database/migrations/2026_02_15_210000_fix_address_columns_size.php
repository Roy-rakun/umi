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
        // First, set any existing data to null to avoid truncation issues
        DB::table('users')->whereNotNull('province_id')->update(['province_id' => null]);
        DB::table('users')->whereNotNull('city_id')->update(['city_id' => null]);
        DB::table('users')->whereNotNull('district_id')->update(['district_id' => null]);
        DB::table('users')->whereNotNull('village_id')->update(['village_id' => null]);
        
        Schema::table('users', function (Blueprint $table) {
            // Change column sizes to accommodate format like "15.04", "15.04.07", "15.04.07.1004"
            $table->string('province_id', 10)->nullable()->change();
            $table->string('city_id', 10)->nullable()->change();
            $table->string('district_id', 15)->nullable()->change();
            $table->string('village_id', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('province_id', 2)->nullable()->change();
            $table->char('city_id', 4)->nullable()->change();
            $table->char('district_id', 7)->nullable()->change();
            $table->char('village_id', 10)->nullable()->change();
        });
    }
};