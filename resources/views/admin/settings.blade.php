@extends('layouts.admin')
@section('title', 'System Settings')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-bold mb-6">Configuration</h3>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <!-- General Settings -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold mb-4 border-b pb-2">General Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'The Secret' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (Outer) %</label>
                    <input type="number" name="default_commission_outer" value="{{ $settings['default_commission_outer'] ?? '10' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
            </div>
        </div>

        <!-- Checkout Settings -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold mb-4 border-b pb-2">Checkout Settings</h4>
            <div class="flex items-center">
                <input type="hidden" name="require_login_checkout" value="0">
                <input type="checkbox" name="require_login_checkout" value="1" id="require_login_checkout" {{ ($settings['require_login_checkout'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mr-2">
                <label for="require_login_checkout" class="text-sm font-medium text-gray-700">Wajib Login untuk Membeli/Checkout</label>
            </div>
            <p class="text-xs text-gray-400 mt-1 italic pl-6">Jika diaktifkan, pengunjung harus login atau daftar akun terlebih dahulu sebelum bisa memproses pembelian.</p>
        </div>

        <!-- Navigation & Social Links -->
        <div class="mb-8 p-6 bg-pink-50/30 rounded-2xl border border-pink-100">
            <h4 class="text-lg font-semibold mb-6 border-b border-pink-100 pb-2 text-primary">Navigation & Social Media</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                     <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Social Media (URL)</label>
                     <div class="space-y-4">
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center justify-center bg-white rounded-l border border-r-0 border-gray-300 text-pink-600"><i class="fab fa-tiktok"></i></span>
                            <input type="text" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? '#' }}" class="flex-1 p-2 border border-gray-300 rounded-r focus:ring-primary focus:border-primary" placeholder="Tiktok URL">
                        </div>
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center justify-center bg-white rounded-l border border-r-0 border-gray-300 text-pink-600"><i class="fab fa-instagram"></i></span>
                            <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? '#' }}" class="flex-1 p-2 border border-gray-300 rounded-r focus:ring-primary focus:border-primary" placeholder="Instagram URL">
                        </div>
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center justify-center bg-white rounded-l border border-r-0 border-gray-300 text-pink-600"><i class="fab fa-youtube"></i></span>
                            <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? '#' }}" class="flex-1 p-2 border border-gray-300 rounded-r focus:ring-primary focus:border-primary" placeholder="YouTube URL">
                        </div>
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center justify-center bg-white rounded-l border border-r-0 border-gray-300 text-green-600"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" name="social_whatsapp" value="{{ $settings['social_whatsapp'] ?? '628...' }}" class="flex-1 p-2 border border-gray-300 rounded-r focus:ring-primary focus:border-primary" placeholder="WhatsApp Number (Start with 62)">
                        </div>
                     </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Navbar Menu Labels</label>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Menu 1 (About)</label>
                            <input type="text" name="nav_label_about" value="{{ $settings['nav_label_about'] ?? 'Tentang' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Menu 2 (Products)</label>
                            <input type="text" name="nav_label_products" value="{{ $settings['nav_label_products'] ?? 'Produk' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Menu 3 (Affiliate)</label>
                            <input type="text" name="nav_label_affiliate" value="{{ $settings['nav_label_affiliate'] ?? 'Affiliate' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Menu 4 (Contact)</label>
                            <input type="text" name="nav_label_contact" value="{{ $settings['nav_label_contact'] ?? 'Kontak' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Gateway (Mayar.id) -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div class="flex items-center mb-4">
                <img src="https://mayar.id/assets/images/logo/logo-dark-surrounded.svg" alt="Mayar Logo" class="h-8 mr-3">
                <h4 class="text-lg font-semibold">Payment Gateway (Mayar.id)</h4>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Environment</label>
                    <select name="mayar_environment" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                        <option value="sandbox" {{ ($settings['mayar_environment'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                        <option value="production" {{ ($settings['mayar_environment'] ?? '') == 'production' ? 'selected' : '' }}>Production (Live)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                    <input type="password" name="mayar_api_key" value="{{ $settings['mayar_api_key'] ?? '' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="MYR-...">
                    <p class="text-xs text-gray-500 mt-1">Get your API Key from Mayar Dashboard > Integration > API Keys</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                    <div class="flex items-center">
                        <input type="text" value="{{ route('api.webhook.mayar') }}" readonly class="flex-1 bg-gray-100 p-2 border border-gray-300 rounded-l text-gray-600">
                        <button type="button" onclick="navigator.clipboard.writeText('{{ route('api.webhook.mayar') }}')" class="bg-gray-200 px-4 py-2 border border-l-0 border-gray-300 rounded-r hover:bg-gray-300 text-sm">Copy</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Register this URL in Mayar Dashboard > Integration > Webhooks</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Webhook Secret (Optional)</label>
                    <input type="password" name="mayar_webhook_secret" value="{{ $settings['mayar_webhook_secret'] ?? '' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="Secret for signature verification">
                    <p class="text-xs text-gray-500 mt-1">Used to verify webhook signatures for security. Set this in Mayar Dashboard too.</p>
                </div>
            </div>
        </div>

        <!-- J&T Express Settings -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div class="flex items-center mb-4">
                <i class="fas fa-truck text-[#FF0000] text-xl mr-3"></i>
                <h4 class="text-lg font-semibold">Shipping (J&T Express)</h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client ID (Ecommerce ID)</label>
                    <input type="text" name="jnt_client_id" value="{{ $settings['jnt_client_id'] ?? '' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="JET-...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Key (Data Digest Password)</label>
                    <input type="password" name="jnt_api_key" value="{{ $settings['jnt_api_key'] ?? '' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Origin Store Address</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="origin_province" value="{{ $settings['origin_province'] ?? '' }}" placeholder="Province (e.g. DKI Jakarta)" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                        <input type="text" name="origin_city" value="{{ $settings['origin_city'] ?? '' }}" placeholder="City (e.g. Jakarta Selatan)" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                        <input type="text" name="origin_district" value="{{ $settings['origin_district'] ?? '' }}" placeholder="District (e.g. Setiabudi)" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Exact naming is required by J&T API.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#2C3E50] text-white px-6 py-2 rounded hover:bg-[#1A252F] transition-colors">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
