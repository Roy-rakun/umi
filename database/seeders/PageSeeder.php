<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Privacy Policy
        Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'content' => '
                    <h2 class="text-2xl font-serif mb-4">Privacy Policy</h2>
                    <p class="mb-4">Last updated: ' . date('F d, Y') . '</p>
                    <p class="mb-4">The Secret by Umy Fadillaa ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by The Secret by Umy Fadillaa.</p>
                    
                    <h3 class="text-xl font-serif mb-2">1. Information We Collect</h3>
                    <p class="mb-4">We collect information you provide directly to us, such as when you create an account, make a purchase, or communicate with us.</p>
                    
                    <h3 class="text-xl font-serif mb-2">2. How We Use Your Information</h3>
                    <p class="mb-4">We use the information we collect to provide, maintain, and improve our services, process transactions, and send you related information.</p>
                    
                    <h3 class="text-xl font-serif mb-2">3. Sharing of Information</h3>
                    <p class="mb-4">We do not share your personal information with third parties except as described in this policy or with your consent.</p>
                '
            ]
        );

        // 2. Terms of Service
        Page::updateOrCreate(
            ['slug' => 'terms-of-service'],
            [
                'title' => 'Terms of Service',
                'content' => '
                    <h2 class="text-2xl font-serif mb-4">Terms of Service</h2>
                    <p class="mb-4">Please read these Terms of Service carefully before using our website.</p>
                    
                    <h3 class="text-xl font-serif mb-2">1. Acceptance of Terms</h3>
                    <p class="mb-4">By accessing or using our service, you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the service.</p>
                    
                    <h3 class="text-xl font-serif mb-2">2. Purchases</h3>
                    <p class="mb-4">If you wish to purchase any product or service made available through the Service, you may be asked to supply certain information relevant to your Purchase.</p>
                    
                    <h3 class="text-xl font-serif mb-2">3. Content</h3>
                    <p class="mb-4">Our Service allows you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material.</p>
                '
            ]
        );

        // 3. Affiliate Terms (Source: BRD Affiliate_Guidelines)
        Page::updateOrCreate(
            ['slug' => 'affiliate-terms'],
            [
                'title' => 'Affiliate Terms & Guidelines',
                'content' => '
                    <h2 class="text-2xl font-serif mb-4">Panduan & Syarat Affiliate Resmi</h2>
                    <p class="mb-4">Selamat datang di Program Affiliate “The Secret” by @umyfadillaa. Dokumen ini dibuat khusus untuk kamu agar mudah paham, nyaman jalanin, dan jelas aturannya.</p>

                    <h3 class="text-xl font-serif mb-2 mt-6">🌟 Apa Itu Program Affiliate Ini?</h3>
                    <p class="mb-4">Program affiliate ini adalah program bagi hasil komisi. Kamu membantu merekomendasikan produk-produk Rahasia Tarik Rejeki, dan kamu akan mendapatkan komisi dari setiap penjualan yang berhasil.</p>

                    <h3 class="text-xl font-serif mb-2 mt-6">📦 Jenis Affiliate</h3>
                    <ul class="list-disc pl-5 mb-4 space-y-2">
                        <li><strong>OUTER CIRCLE (Affiliate Umum):</strong> Terbuka untuk siapa saja, komisi standar.</li>
                        <li><strong>INNER CIRCLE (Affiliate Terpilih):</strong> Affiliate pilihan, komisi lebih besar. Status Inner Circle ditentukan oleh tim.</li>
                    </ul>

                    <h3 class="text-xl font-serif mb-2 mt-6">⏳ Aturan Penting (Wajib Dibaca)</h3>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-100 mb-6">
                        <strong class="text-red-700 block mb-2">❌ DILARANG KERAS:</strong>
                        <ul class="list-disc pl-5 text-red-700 space-y-1">
                            <li>Membeli produk sendiri pakai link sendiri (Self-Order)</li>
                            <li>Spam link sembarangan</li>
                            <li>Klaim berlebihan / menyesatkan</li>
                            <li>Menggunakan akun palsu atau bot</li>
                        </ul>
                    </div>

                    <h3 class="text-xl font-serif mb-2 mt-6">🛡 Keamanan & Keadilan</h3>
                    <p class="mb-4">Sistem kami otomatis mendeteksi Self-order, Traffic palsu, dan Penyalahgunaan link. Jika melanggar, komisi akan hangus dan akun bisa disuspend.</p>

                    <h3 class="text-xl font-serif mb-2 mt-6">💰 Komisi & Pembayaran</h3>
                    <ul class="list-disc pl-5 mb-4 space-y-2">
                        <li>Komisi dihitung per transaksi sukses (PAID).</li>
                        <li>Pembayaran komisi dilakukan secara berkala ke rekening kamu.</li>
                    </ul>

                    <p class="mt-8 italic text-center">"Rejeki terbaik datang dari cara yang baik. Terima kasih sudah menjadi bagian dari Rahasia Tarik Rejeki."</p>
                '
            ]
        );

        // 4. Contact
        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'content' => '
                    <h2 class="text-2xl font-serif mb-4">Contact Us</h2>
                    <p class="mb-6">Have any questions or need assistance? We are here to help you on your spiritual journey.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-pink-50 p-6 rounded-xl">
                            <h3 class="font-bold text-lg mb-2">Customer Support</h3>
                            <p class="text-gray-600 mb-2">For general inquiries and order support:</p>
                            <a href="mailto:support@thesecretbyumy.com" class="text-primary hover:underline">support@thesecretbyumy.com</a>
                        </div>
                        
                        <div class="bg-pink-50 p-6 rounded-xl">
                            <h3 class="font-bold text-lg mb-2">Affiliate Support</h3>
                            <p class="text-gray-600 mb-2">For affiliate program related questions:</p>
                            <a href="mailto:affiliate@thesecretbyumy.com" class="text-primary hover:underline">affiliate@thesecretbyumy.com</a>
                        </div>
                    </div>

                    <h3 class="text-xl font-serif mb-4">Follow Us</h3>
                    <p class="mb-4">Stay connected for daily inspiration and updates.</p>
                    <div class="flex space-x-4">
                        <span class="text-gray-500">Instagram: @thesecretbyumy</span>
                        <span class="text-gray-500">TikTok: @thesecretbyumy</span>
                    </div>
                '
            ]
        );
    }
}
