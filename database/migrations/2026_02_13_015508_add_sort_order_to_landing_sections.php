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
        Schema::table('landing_sections', function (Blueprint $table) {
            $table->integer('sort_order')->default(0);
        });

        // Set default orders
        $order = 1;
        $sections = ['hero', 'problem', 'about', 'explanation', 'affiliate', 'testimonials', 'contact', 'footer'];
        foreach ($sections as $key) {
            DB::table('landing_sections')->where('key', $key)->update(['sort_order' => $order * 10]);
            $order++;
        }

        // Insert Sosmed Section (Before About - between problem(20) and about(30))
        DB::table('landing_sections')->insert([
            'key' => 'sosmed',
            'name' => 'Social Media Section',
            'sort_order' => 25,
            'content' => json_encode([
                'title' => 'Berbagi Rahasia Menyiapkan Hati',
                'items' => [
                    [
                        'name' => 'Tiktok @umyfadillaa',
                        'icon' => 'lucide:video',
                        'image_url' => null,
                        'button_text' => 'Ikuti',
                        'button_url' => '#'
                    ],
                    [
                        'name' => 'Instagram @umyfadillaa',
                        'icon' => 'lucide:instagram',
                        'image_url' => null,
                        'button_text' => 'Ikuti',
                        'button_url' => '#'
                    ],
                    [
                        'name' => 'Youtube @umyfadilla29',
                        'icon' => 'lucide:youtube',
                        'image_url' => null,
                        'button_text' => 'Ikuti',
                        'button_url' => '#'
                    ]
                ]
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_sections', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
        DB::table('landing_sections')->where('key', 'sosmed')->delete();
    }
};
