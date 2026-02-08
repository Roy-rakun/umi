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

        <!-- Social Media Settings -->
        <div class="mb-8">
            <h4 class="text-lg font-semibold mb-4 border-b pb-2">Social Media Links</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">TikTok URL</label>
                    <input type="text" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? '#' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="https://tiktok.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                    <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? '#' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="https://instagram.com/...">
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                    <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? '#' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="https://youtube.com/...">
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
