<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'name' => 'Hero Section',
                'content' => [
                    'headline' => 'Rahasia Keajaiban Do\'a & Keberlimpahan Berkah',
                    'tagline' => 'Apakah kamu merasa lelah dengan usaha yang belum membuahkan hasil? Merasa doa-doamu belum terjawab? Kamu tidak sendirian. Temukan rahasia menyelaraskan hati dan jiwa untuk menerima keberlimpahan yang telah Allah sediakan untukmu.',
                    'primary_button' => 'Gabung Sekarang',
                    'secondary_button' => 'Pelajari Lebih Lanjut',
                ],
            ],
            [
                'key' => 'problem',
                'name' => 'Problem Section',
                'content' => [
                    'title' => 'Merasa Hidup Terasa Berat dan Stagnan?',
                    'card_1' => [
                        'icon' => 'lucide:lightbulb',
                        'title' => 'Sudah Berusaha Keras',
                        'description' => 'Kamu sudah bekerja keras, belajar banyak hal, tapi hasilnya belum sesuai harapan. Merasa seperti ada yang kurang.',
                    ],
                    'card_2' => [
                        'icon' => 'lucide:heart',
                        'title' => 'Doa Belum Terwujud',
                        'description' => 'Sudah berdoa dengan sungguh-sungguh, tapi merasa seperti doa belum sampai. Ada kesenjangan antara harapan dan kenyataan.',
                    ],
                    'card_3' => [
                        'icon' => 'lucide:refresh-cw',
                        'title' => 'Lelah & Kehilangan Arah',
                        'description' => 'Merasa lelah, kehilangan motivasi, dan tidak tahu harus mulai dari mana untuk memperbaiki keadaan.',
                    ],
                ],
            ],
            [
                'key' => 'about',
                'name' => 'About Section',
                'content' => [
                    'badge' => 'Tentang Mentor',
                    'title' => 'Umy Fadilla',
                    'description' => '<p>Umy Fadilla adalah seorang praktisi spiritual dan mentor transformasi diri yang telah membantu ribuan orang menemukan keselarasan antara hati, pikiran, dan tindakan mereka.</p>
                                    <p>Dengan pendekatan yang menggabungkan nilai-nilai Islam dan pemahaman mendalam tentang energi spiritual, Umy membimbing setiap individu untuk membuka pintu keberlimpahan yang telah Allah sediakan.</p>
                                    <p>Melalui program "The Secret", Umy berbagi rahasia bagaimana menyiapkan hati dan jiwa agar doa-doa kita tidak hanya diucapkan, tetapi benar-benar terhubung dengan Sang Pencipta.</p>',
                    'stats' => [
                        ['label' => 'Alumni', 'value' => '5000+'],
                        ['label' => 'Kelas', 'value' => '50+'],
                        ['label' => 'Rating', 'value' => '4.9'],
                    ],
                ],
            ],
            [
                'key' => 'explanation',
                'name' => 'Program Explanation',
                'content' => [
                    'title' => 'Menguak Rahasia Keajaiban Do\'a',
                    'description' => '<p>Pernahkah kamu bertanya mengapa sebagian doa terasa begitu mudah terkabul, sementara yang lain seakan tak sampai? Jawabannya bukan pada banyaknya kata atau lamanya sujud.</p>
                                    <p><strong>Rahasia sejati terletak pada keselarasan batin.</strong> Ketika hati, pikiran, dan jiwa kita selaras dengan apa yang kita minta, pintu-pintu keberlimpahan mulai terbuka.</p>
                                    <p>Program "The Secret" akan membimbingmu untuk membersihkan hati dari penghalang-penghalang tersembunyi, menyiapkan wadah jiwamu untuk menerima berkah, dan menghubungkan setiap doamu langsung ke langit.</p>',
                    'button_text' => 'Mulai Perjalanan Spiritualmu',
                ],
            ],
            [
                'key' => 'affiliate',
                'name' => 'Affiliate Section',
                'content' => [
                    'badge' => 'Peluang Berberkah',
                    'title' => 'Program Affiliate The Secret',
                    'description' => 'Sebarkan kebaikan dan dapatkan rezeki halal. Bergabunglah menjadi affiliate kami dan bantu orang lain menemukan jalan spiritual mereka.',
                    'card_1' => [
                        'icon' => 'lucide:dollar-sign',
                        'title' => 'Komisi Menarik',
                        'description' => 'Dapatkan komisi hingga 20% dari setiap penjualan yang kamu hasilkan.',
                    ],
                    'card_2' => [
                        'icon' => 'lucide:bar-chart-3',
                        'title' => 'Dashboard Tracking',
                        'description' => 'Pantau performa dan penghasilanmu dengan dashboard yang mudah digunakan.',
                    ],
                    'card_3' => [
                        'icon' => 'lucide:shield-check',
                        'title' => 'Sistem Aman',
                        'description' => 'Transparan dan terpercaya dengan pembayaran tepat waktu setiap bulan.',
                    ],
                    'register_button' => 'Daftar Affiliate',
                    'login_button' => 'Login Affiliate',
                ],
            ],
            [
                'key' => 'testimonials',
                'name' => 'Testimonials Section',
                'content' => [
                    'badge' => 'Testimoni',
                    'title' => 'Kisah Transformasi Mereka',
                    'items' => [
                        [
                            'name' => 'Siti Nurhaliza',
                            'role' => 'Pengusaha, Jakarta',
                            'content' => 'Setelah mengikuti kelas Umy, hidup saya berubah total. Doa-doa yang dulu terasa hampa, kini terasa begitu dekat dan penuh makna. Rezeki pun mengalir dari arah yang tidak terduga.',
                            'avatar' => 'lucide:user',
                        ],
                        [
                            'name' => 'Anisa Rahma',
                            'role' => 'Karyawan, Bandung',
                            'content' => 'Alhamdulillah, saya menemukan ketenangan yang selama ini saya cari. Kelas private dengan Umy membantu saya memahami apa yang menghalangi doa saya selama ini.',
                            'avatar' => 'lucide:user',
                        ],
                        [
                            'name' => 'Dewi Safitri',
                            'role' => 'Guru, Surabaya',
                            'content' => 'Produk-produk The Secret sangat membantu saya fokus dalam ibadah. Tasbih kristalnya indah dan membawa energi positif yang terasa berbeda saat berdzikir.',
                            'avatar' => 'lucide:user',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'contact',
                'name' => 'Contact Section',
                'content' => [
                    'title' => 'Hubungi Kami',
                    'description' => 'Ada pertanyaan? Jangan ragu untuk menghubungi kami melalui channel resmi di bawah ini.',
                    'channels' => [
                        ['name' => 'WhatsApp', 'icon' => 'lucide:message-circle', 'url' => '#'],
                        ['name' => '@umyfadilla', 'icon' => 'lucide:instagram', 'url' => 'https://instagram.com/umyfadilla'],
                        ['name' => '@umyfadillaa', 'icon' => 'lucide:music', 'url' => 'https://tiktok.com/@umyfadillaa'],
                        ['name' => '@UmyFadilla29', 'icon' => 'lucide:youtube', 'url' => 'https://youtube.com/@UmyFadilla29'],
                    ],
                    'warning_text' => 'Akun resmi hanya yang tercantum di atas. Hati-hati terhadap penipuan.',
                ],
            ],
            [
                'key' => 'footer',
                'name' => 'Footer Section',
                'content' => [
                    'copyright' => '© 2024 The Secret. All rights reserved.',
                    'links' => [
                        ['name' => 'Privacy Policy', 'url' => '#'],
                        ['name' => 'Terms & Conditions', 'url' => '#'],
                        ['name' => 'Affiliate Agreement', 'url' => '#'],
                    ],
                ],
            ],
        ];

        foreach ($sections as $section) {
            \App\Models\LandingSection::updateOrCreate(
                ['key' => $section['key']],
                ['name' => $section['name'], 'content' => $section['content']]
            );
        }
    }
}
