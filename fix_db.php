<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Starting DB Fix...\n";

try {
    if (Schema::hasColumn('products', 'type')) {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'weight']);
        });
        echo "Dropped products columns (type, weight).\n";
    } else {
        echo "Products columns already clean.\n";
    }

    if (Schema::hasColumn('orders', 'shipping_cost')) {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'shipping_details']);
        });
        echo "Dropped orders columns (shipping_cost, shipping_details).\n";
    } else {
        echo "Orders columns already clean.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Done.\n";
