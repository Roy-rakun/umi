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

        <!-- Indonesia Expedition Cost API Settings -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200" x-data="originLocationSelector({
            selectedProvince: '{{ $settings['origin_province_id'] ?? '' }}',
            selectedCity: '{{ $settings['origin_city_id_api'] ?? '' }}',
            selectedDistrict: '{{ $settings['origin_district_id'] ?? '' }}',
            selectedVillage: '{{ $settings['origin_village_id'] ?? '' }}',
            postalCode: '{{ $settings['origin_postal_code'] ?? '' }}'
        })">
            <div class="flex items-center mb-4">
                <i class="fas fa-truck text-[#FF0000] text-xl mr-3"></i>
                <h4 class="text-lg font-semibold">Shipping (J&T Express via API Indonesia)</h4>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm text-blue-800 font-medium">API Indonesia Expedition Cost</p>
                        <p class="text-xs text-blue-600 mt-1">Menggunakan API dari <a href="https://docs.api.co.id/api/indonesia-expedition-cost/" target="_blank" class="underline">docs.api.co.id</a> untuk menghitung ongkir J&T Express.</p>
                    </div>
                </div>
            </div>
            
            <!-- API Key Setting -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                    <input type="password" name="indonesia_expedition_api_key" value="{{ $settings['indonesia_expedition_api_key'] ?? 'Bp3gPph4yGCL3SYBrEVBLXvMZpXUs0RibG26nwtE45b7XDnvuu' }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="Masukkan API Key dari docs.api.co.id">
                    <p class="text-xs text-gray-500 mt-1">Dapatkan API Key dari <a href="https://docs.api.co.id" target="_blank" class="text-blue-500 underline">docs.api.co.id</a></p>
                </div>
            </div>
            
            <!-- Origin Location Selector -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h5 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Lokasi Asal Pengiriman</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Province -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                        <select name="origin_province_id" x-model="selectedProvince" @change="loadCities()" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" required>
                            <option value="">Pilih Provinsi</option>
                            <template x-for="prov in provinces" :key="prov.code">
                                <option :value="prov.code" x-text="prov.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <!-- City -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                        <select name="origin_city_id_api" x-model="selectedCity" @change="loadDistricts()" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" :disabled="!selectedProvince" required>
                            <option value="">Pilih Kota</option>
                            <template x-for="city in cities" :key="city.code">
                                <option :value="city.code" x-text="city.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <!-- District -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                        <select name="origin_district_id" x-model="selectedDistrict" @change="loadVillages()" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" :disabled="!selectedCity" required>
                            <option value="">Pilih Kecamatan</option>
                            <template x-for="dist in districts" :key="dist.code">
                                <option :value="dist.code" x-text="dist.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <!-- Village -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelurahan</label>
                        <select name="origin_village_id" x-model="selectedVillage" @change="updatePostalCode()" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" :disabled="!selectedDistrict" required>
                            <option value="">Pilih Kelurahan</option>
                            <template x-for="vill in villages" :key="vill.code">
                                <option :value="vill.code" x-text="vill.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <!-- Postal Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                        <input type="text" name="origin_postal_code" x-model="postalCode" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="Kode Pos" readonly>
                    </div>
                    
                    <!-- City Name for Display -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kota (untuk invoice)</label>
                        <input type="text" name="origin_city_name" x-model="selectedCityName" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="Nama kota untuk ditampilkan">
                    </div>
                </div>
                
                <!-- Hidden field for API city ID -->
                <input type="hidden" name="origin_city_id" x-model="selectedCity">
            </div>
            
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                    <div>
                        <p class="text-sm text-yellow-800"><strong>Kurir Aktif:</strong> J&T Express saja</p>
                        <p class="text-xs text-yellow-600 mt-1">Saat ini sistem hanya menggunakan J&T Express untuk pengiriman.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @push('scripts')
        <script>
            function originLocationSelector(config) {
                return {
                    provinces: [],
                    cities: [],
                    districts: [],
                    villages: [],
                    selectedProvince: config.selectedProvince || '',
                    selectedCity: config.selectedCity || '',
                    selectedDistrict: config.selectedDistrict || '',
                    selectedVillage: config.selectedVillage || '',
                    postalCode: config.postalCode || '',
                    selectedCityName: config.selectedCityName || '',
                    initialized: false,
                    
                    async init() {
                        await this.loadProvinces();
                        if (this.selectedProvince) {
                            await this.loadCities(true);
                        }
                        this.initialized = true;
                    },
                    
                    async loadProvinces() {
                        try {
                            const response = await fetch('/api/regions/provinces');
                            this.provinces = await response.json();
                        } catch (e) {
                            console.error('Failed to load provinces:', e);
                        }
                    },
                    
                    async loadCities(initialLoad = false) {
                        // Don't reset if this is initial load
                        if (!initialLoad) {
                            this.cities = [];
                            this.districts = [];
                            this.villages = [];
                            this.selectedCity = '';
                            this.selectedDistrict = '';
                            this.selectedVillage = '';
                            this.postalCode = '';
                            this.selectedCityName = '';
                        }
                        
                        if (this.selectedProvince) {
                            try {
                                const response = await fetch(`/api/regions/cities/${this.selectedProvince}`);
                                this.cities = await response.json();
                                
                                // If initial load, wait for cities to load then restore selection
                                if (initialLoad && config.selectedCity) {
                                    // Wait a tick for the select to update
                                    await this.$nextTick();
                                    this.selectedCity = config.selectedCity;
                                    await this.loadDistricts(true);
                                }
                            } catch (e) {
                                console.error('Failed to load cities:', e);
                            }
                        }
                    },
                    
                    async loadDistricts(initialLoad = false) {
                        if (!initialLoad) {
                            this.districts = [];
                            this.villages = [];
                            this.selectedDistrict = '';
                            this.selectedVillage = '';
                            this.postalCode = '';
                        }
                        
                        if (this.selectedCity) {
                            // Update city name
                            const city = this.cities.find(c => c.code === this.selectedCity);
                            this.selectedCityName = city ? city.name : '';
                            
                            try {
                                const response = await fetch(`/api/regions/districts/${this.selectedCity}`);
                                this.districts = await response.json();
                                
                                if (initialLoad && config.selectedDistrict) {
                                    await this.$nextTick();
                                    this.selectedDistrict = config.selectedDistrict;
                                    await this.loadVillages(true);
                                }
                            } catch (e) {
                                console.error('Failed to load districts:', e);
                            }
                        }
                    },
                    
                    async loadVillages(initialLoad = false) {
                        if (!initialLoad) {
                            this.villages = [];
                            this.selectedVillage = '';
                            this.postalCode = '';
                        }
                        
                        if (this.selectedDistrict) {
                            try {
                                const response = await fetch(`/api/regions/villages/${this.selectedDistrict}`);
                                this.villages = await response.json();
                                
                                if (initialLoad && config.selectedVillage) {
                                    await this.$nextTick();
                                    this.selectedVillage = config.selectedVillage;
                                    this.updatePostalCode();
                                }
                            } catch (e) {
                                console.error('Failed to load villages:', e);
                            }
                        }
                    },
                    
                    updatePostalCode() {
                        if (this.selectedVillage) {
                            const village = this.villages.find(v => v.code === this.selectedVillage);
                            this.postalCode = village ? (village.postal_code || '') : '';
                        }
                    }
                }
            }
        </script>
        @endpush

        <div class="flex justify-end">
            <button type="submit" class="bg-[#2C3E50] text-white px-6 py-2 rounded hover:bg-[#1A252F] transition-colors">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
