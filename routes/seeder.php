<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Route::get('/fix-db', function () {
    try {
        if (Schema::hasColumn('products', 'type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn(['type', 'weight']);
            });
            echo "Dropped products columns.<br>";
        } else {
             echo "Products columns already gone.<br>";
        }

        if (Schema::hasColumn('orders', 'shipping_cost')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn(['shipping_cost', 'shipping_details']);
            });
            echo "Dropped orders columns.<br>";
        } else {
             echo "Orders columns already gone.<br>";
        }
        
        return 'DB Fixed.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
