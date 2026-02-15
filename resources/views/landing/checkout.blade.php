<!doctype html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $settings['site_name'] ?? 'The Secret' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Nunito+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <style>
        :root {
            --color-bg: #fff7f6;
            --color-surface: #ffffff;
            --color-text: #4a3f3f;
            --color-primary: #7d2a2a;
            --color-secondary: #d4a574;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            font-family: 'Nunito Sans', sans-serif;
        }

        .font-heading {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>
<body class="h-full bg-[#fff7f6]">
    <div x-data="checkoutPage({
        initialProduct: {{ json_encode($product) }},
        allProducts: {{ json_encode($allProducts) }},
        settings: {{ json_encode($settings) }},
        isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
        loginUrl: '{{ route('login') }}',
        user: {{ auth()->check() ? json_encode(auth()->user()->only(['name', 'email', 'phone', 'province_id', 'city_id', 'district_id', 'village_id', 'postal_code', 'address_detail'])) : 'null' }}
    })" class="max-w-5xl mx-auto px-4 py-12">
        
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-primary mb-2">Checkout</h1>
            <p class="text-gray-500">Selesaikan pesanan Anda untuk memulai perjalanan spiritual.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Cart & More Products -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Cart Items -->
                <div class="bg-white rounded-3xl shadow-sm border border-pink-100 p-6 md:p-8">
                    <h2 class="text-xl font-heading font-bold text-primary mb-6 flex items-center gap-2">
                        <i class="fas fa-shopping-basket text-sm"></i>
                        Pilihan Anda
                    </h2>
                    <div class="space-y-6">
                        <template x-for="(item, index) in cart" :key="item.product_id">
                            <div class="flex items-center gap-4 bg-pink-50/30 p-4 rounded-2xl relative overflow-hidden group">
                                <div class="w-20 h-20 rounded-xl bg-white flex items-center justify-center border border-pink-100/50 shadow-sm shrink-0">
                                    <template x-if="item.image_url">
                                        <img :src="item.image_url" class="w-full h-full object-cover rounded-xl">
                                    </template>
                                    <template x-if="!item.image_url">
                                        <iconify-icon :icon="item.icon || 'lucide:package'" class="text-3xl text-primary/40"></iconify-icon>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <h3 x-text="item.name" class="font-bold text-gray-800 leading-tight"></h3>
                                    <p class="text-xs text-gray-400 mt-1" x-text="item.type"></p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-primary font-bold" x-text="formatPrice(item.price)"></span>
                                        <div class="flex items-center gap-3">
                                            <button @click="updateQty(index, -1)" class="w-8 h-8 rounded-full bg-white border border-pink-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                                                <i class="fas fa-minus text-[10px]"></i>
                                            </button>
                                            <span x-text="item.qty" class="text-sm font-bold w-4 text-center"></span>
                                            <button @click="updateQty(index, 1)" class="w-8 h-8 rounded-full bg-white border border-pink-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                                                <i class="fas fa-plus text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button @click="removeItem(index)" class="absolute top-2 right-2 p-2 text-gray-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Add More Products -->
                <div>
                    <h2 class="text-xl font-heading font-bold text-primary mb-6 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-sm"></i>
                        Tambahkan Produk Lainnya
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="prod in availableProducts" :key="prod.product_id">
                            <div class="bg-white p-4 rounded-2xl border border-pink-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4 cursor-pointer" @click="addToCart(prod)">
                                <div class="w-16 h-16 rounded-xl bg-pink-50 flex items-center justify-center shrink-0">
                                    <template x-if="prod.image_url">
                                        <img :src="prod.image_url" class="w-full h-full object-cover rounded-xl">
                                    </template>
                                    <template x-if="!prod.image_url">
                                        <iconify-icon :icon="prod.icon || 'lucide:package'" class="text-2xl text-primary/40"></iconify-icon>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <h4 x-text="prod.name" class="text-sm font-bold text-gray-800 line-clamp-1"></h4>
                                    <p class="text-xs text-primary font-bold mt-1" x-text="formatPrice(prod.price)"></p>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                    <i class="fas fa-plus text-[10px]"></i>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Shipping Address (Only for physical products) -->
                <div x-show="hasPhysicalProducts" class="bg-white rounded-3xl shadow-sm border border-pink-100 p-6 md:p-8">
                    <h2 class="text-xl font-heading font-bold text-primary mb-6 flex items-center gap-2">
                        <i class="fas fa-truck text-sm"></i>
                        Alamat Pengiriman
                    </h2>
                    
                    <!-- Use Profile Address Option (only for logged in users with address) -->
                    <template x-if="config.isLoggedIn && config.user && config.user.city_id">
                        <div class="mb-4">
                            <label class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl cursor-pointer hover:bg-green-100 transition-colors">
                                <input type="checkbox" x-model="useProfileAddress" @change="toggleProfileAddress()" class="w-5 h-5 rounded border-green-300 text-green-600 focus:ring-green-500">
                                <div class="flex-1">
                                    <span class="text-sm font-bold text-green-800">Gunakan Alamat Profile</span>
                                    <p class="text-xs text-green-600 mt-1" x-text="getProfileAddressText()"></p>
                                </div>
                            </label>
                        </div>
                    </template>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Provinsi</label>
                                <select x-model="shipping.province_id" @change="onProvinceChange()" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" required :disabled="useProfileAddress">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.code">
                                        <option :value="prov.code" x-text="prov.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Kota/Kabupaten</label>
                                <select x-model="shipping.city_id" @change="onCityChange()" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" required :disabled="!shipping.province_id || useProfileAddress">
                                    <option value="">Pilih Kota</option>
                                    <template x-for="city in cities" :key="city.code">
                                        <option :value="city.code" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Kecamatan</label>
                                <select x-model="shipping.district_id" @change="onDistrictChange()" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" required :disabled="!shipping.city_id || useProfileAddress">
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="dist in districts" :key="dist.code">
                                        <option :value="dist.code" x-text="dist.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Kelurahan</label>
                                <select x-model="shipping.village_id" @change="onVillageChange()" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" required :disabled="!shipping.district_id || useProfileAddress">
                                    <option value="">Pilih Kelurahan</option>
                                    <template x-for="vill in villages" :key="vill.code">
                                        <option :value="vill.code" x-text="vill.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Alamat Lengkap</label>
                            <textarea x-model="shipping.address" rows="3" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Jl. Contoh No. 123, RT/RW, Kode Pos" required :disabled="useProfileAddress"></textarea>
                        </div>

                        <!-- Shipping Options -->
                        <div x-show="shippingOptions.length > 0" class="mt-6 pt-6 border-t border-pink-100">
                            <h3 class="text-sm font-bold text-gray-700 mb-4">Pilihan Pengiriman (J&T Express)</h3>
                            <div class="space-y-3">
                                <template x-for="(option, index) in shippingOptions" :key="option.service">
                                    <div class="flex items-center gap-4 p-4 bg-pink-50/30 rounded-xl cursor-pointer hover:bg-pink-50 transition-colors" 
                                         :class="{'ring-2 ring-primary': selectedShippingService === option.service}"
                                         @click="selectShipping(index)">
                                        <div class="w-5 h-5 rounded-full border-2 border-primary flex items-center justify-center" 
                                             :class="{'bg-primary': selectedShippingService === option.service}">
                                            <div x-show="selectedShippingService === option.service" class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-800" x-text="option.service"></span>
                                                <span class="text-xs text-gray-400" x-text="option.description"></span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span x-text="'Estimasi ' + option.etd + ' hari'"></span>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-bold text-primary" x-text="formatPrice(option.cost)"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Loading shipping -->
                        <div x-show="loadingShipping" class="flex items-center justify-center py-8">
                            <i class="fas fa-circle-notch fa-spin text-primary text-2xl"></i>
                            <span class="ml-3 text-gray-500">Menghitung ongkir...</span>
                        </div>
                        
                        <!-- Error shipping -->
                        <div x-show="shippingError" class="p-4 bg-red-50 border border-red-200 rounded-xl">
                            <p class="text-sm text-red-600" x-text="shippingError"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Buyer Info & Summary -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Buyer Form -->
                <div class="bg-white rounded-3xl shadow-sm border border-pink-100 p-8">
                    <!-- User Session Info (for logged in users) -->
                    <template x-if="config.isLoggedIn && config.user">
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-green-800" x-text="config.user.name"></p>
                                    <p class="text-xs text-green-600" x-text="config.user.email"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <h2 class="text-xl font-heading font-bold text-primary mb-6">Informasi Pembeli</h2>
                    <form @submit.prevent="submitOrder">
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                                <input type="text" x-model="buyer.name" required class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Contoh: Siti Aisyah">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Email</label>
                                <input type="email" x-model="buyer.email" required class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" placeholder="siti@example.com">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">WhatsApp</label>
                                <input type="tel" x-model="buyer.phone" class="w-full p-3 bg-pink-50/30 border border-pink-100 rounded-xl focus:ring-primary focus:border-primary outline-none transition-all" placeholder="081234567890">
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-pink-50">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-400 text-sm">Subtotal</span>
                                <span class="text-gray-800 font-bold" x-text="formatPrice(totalPrice)"></span>
                            </div>
                            <div x-show="hasPhysicalProducts && selectedShipping" class="flex justify-between items-center mb-2">
                                <span class="text-gray-400 text-sm">Ongkos Kirim (J&T)</span>
                                <span class="text-gray-800 font-bold" x-text="formatPrice(selectedShipping?.cost || 0)"></span>
                            </div>
                            <div class="flex justify-between items-center mb-8">
                                <span class="text-primary font-heading font-bold text-lg">Total</span>
                                <span class="text-primary font-heading font-bold text-2xl" x-text="formatPrice(grandTotal)"></span>
                            </div>

                            <button type="submit" :disabled="loading || (hasPhysicalProducts && shipping.city_id && !selectedShipping)" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-900/20 hover:bg-red-900 transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <template x-if="!loading">
                                    <span>Lanjutkan Pembayaran</span>
                                </template>
                                <template x-if="loading">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-circle-notch fa-spin"></i>
                                        <span>Memproses...</span>
                                    </div>
                                </template>
                                <i x-show="!loading" class="fas fa-arrow-right text-xs"></i>
                            </button>
                            <p x-show="hasPhysicalProducts && shipping.city_id && !selectedShipping && !loadingShipping" class="text-xs text-center text-yellow-600 mt-4">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Tunggu sebentar, sedang menghitung ongkir...
                            </p>
                            <p class="text-[10px] text-center text-gray-400 mt-4 leading-relaxed">
                                Dengan mengklik tombol di atas, Anda menyetujui <br>Syarat & Ketentuan yang berlaku.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutPage', (config) => ({
                config: config,
                cart: [],
                allProducts: config.allProducts,
                settings: config.settings,
                buyer: {
                    name: config.user?.name || '',
                    email: config.user?.email || '',
                    phone: config.user?.phone || '',
                },
                shipping: {
                    province_id: '',
                    city_id: '',
                    district_id: '',
                    village_id: '',
                    address: ''
                },
                provinces: [],
                cities: [],
                districts: [],
                villages: [],
                shippingOptions: [],
                selectedShipping: null,
                selectedShippingService: null,
                loading: false,
                loadingShipping: false,
                shippingError: null,
                useProfileAddress: false,

                init() {
                    const initial = config.initialProduct;
                    this.cart.push({
                        product_id: initial.product_id,
                        name: initial.name,
                        price: initial.price,
                        type: initial.type,
                        weight: initial.weight || 1000,
                        image_url: initial.image_url,
                        icon: initial.icon,
                        qty: 1
                    });
                    
                    // Load provinces
                    this.loadProvinces();
                    
                    // If user has address in profile, auto-fill it
                    if (config.isLoggedIn && config.user && config.user.city_id) {
                        this.useProfileAddress = true;
                        this.fillProfileAddress();
                    }
                },

                get hasPhysicalProducts() {
                    return this.cart.some(item => item.type === 'physical');
                },

                get totalWeight() {
                    return this.cart
                        .filter(item => item.type === 'physical')
                        .reduce((sum, item) => sum + (item.weight * item.qty), 0);
                },

                get availableProducts() {
                    return this.allProducts.filter(p => !this.cart.some(c => c.product_id === p.product_id));
                },

                get totalPrice() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                get grandTotal() {
                    const shippingCost = this.hasPhysicalProducts && this.selectedShipping ? this.selectedShipping.cost : 0;
                    return this.totalPrice + shippingCost;
                },

                getProfileAddressText() {
                    if (!config.user) return '';
                    const parts = [];
                    if (config.user.address_detail) parts.push(config.user.address_detail);
                    if (config.user.postal_code) parts.push(config.user.postal_code);
                    return parts.join(', ') || 'Alamat sudah tersimpan di profile';
                },

                fillProfileAddress() {
                    if (config.user) {
                        this.shipping.province_id = config.user.province_id || '';
                        this.shipping.city_id = config.user.city_id || '';
                        this.shipping.district_id = config.user.district_id || '';
                        this.shipping.village_id = config.user.village_id || '';
                        this.shipping.address = config.user.address_detail || '';
                        
                        // Load cities, districts, villages for the province
                        if (this.shipping.province_id) {
                            this.loadAddressForProfile();
                        }
                    }
                },

                async loadAddressForProfile() {
                    try {
                        // Load cities
                        const citiesRes = await fetch(`/api/regions/cities/${this.shipping.province_id}`);
                        this.cities = await citiesRes.json();
                        
                        // Load districts if city_id exists
                        if (this.shipping.city_id) {
                            const districtsRes = await fetch(`/api/regions/districts/${this.shipping.city_id}`);
                            this.districts = await districtsRes.json();
                        }
                        
                        // Load villages if district_id exists
                        if (this.shipping.district_id) {
                            const villagesRes = await fetch(`/api/regions/villages/${this.shipping.district_id}`);
                            this.villages = await villagesRes.json();
                        }
                        
                        // After all loaded, calculate shipping if village_id exists
                        if (this.shipping.village_id && this.totalWeight > 0) {
                            this.calculateShipping();
                        }
                    } catch (e) {
                        console.error('Failed to load address data:', e);
                    }
                },

                toggleProfileAddress() {
                    if (this.useProfileAddress) {
                        this.fillProfileAddress();
                    } else {
                        // Clear address
                        this.shipping.province_id = '';
                        this.shipping.city_id = '';
                        this.shipping.address = '';
                        this.cities = [];
                        this.shippingOptions = [];
                        this.selectedShipping = null;
                    }
                },

                async loadProvinces() {
                    try {
                        const response = await fetch('/api/regions/provinces');
                        const data = await response.json();
                        this.provinces = data;
                    } catch (e) {
                        console.error('Failed to load provinces:', e);
                    }
                },

                async onProvinceChange() {
                    this.shipping.city_id = '';
                    this.cities = [];
                    this.shippingOptions = [];
                    this.selectedShipping = null;
                    this.shippingError = null;
                    
                    if (this.shipping.province_id) {
                        try {
                            const response = await fetch(`/api/regions/cities/${this.shipping.province_id}`);
                            const data = await response.json();
                            this.cities = data;
                        } catch (e) {
                            console.error('Failed to load cities:', e);
                        }
                    }
                },

                async onCityChange() {
                    this.shipping.district_id = '';
                    this.districts = [];
                    this.villages = [];
                    this.shippingOptions = [];
                    this.selectedShipping = null;
                    this.shippingError = null;
                    
                    if (this.shipping.city_id) {
                        try {
                            const response = await fetch(`/api/regions/districts/${this.shipping.city_id}`);
                            const data = await response.json();
                            this.districts = data;
                        } catch (e) {
                            console.error('Failed to load districts:', e);
                        }
                    }
                },

                async onDistrictChange() {
                    this.shipping.village_id = '';
                    this.villages = [];
                    this.shippingOptions = [];
                    this.selectedShipping = null;
                    this.shippingError = null;
                    
                    if (this.shipping.district_id) {
                        try {
                            const response = await fetch(`/api/regions/villages/${this.shipping.district_id}`);
                            const data = await response.json();
                            this.villages = data;
                        } catch (e) {
                            console.error('Failed to load villages:', e);
                        }
                    }
                },

                async onVillageChange() {
                    this.shippingOptions = [];
                    this.selectedShipping = null;
                    this.shippingError = null;
                    
                    if (this.shipping.village_id && this.totalWeight > 0) {
                        await this.calculateShipping();
                    }
                },

                async calculateShipping() {
                    this.loadingShipping = true;
                    this.shippingError = null;
                    
                    try {
                        const response = await fetch('/api/shipping/calculate', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                destination_village_code: this.shipping.village_id,
                                weight: this.totalWeight
                            })
                        });
                        
                        const result = await response.json();
                        console.log('Shipping result:', result);
                        
                        if (result.status === 'success' && result.data && result.data.length > 0) {
                            this.shippingOptions = result.data;
                            // Auto-select first option
                            this.selectedShipping = this.shippingOptions[0];
                            this.selectedShippingService = this.selectedShipping.service;
                        } else {
                            this.shippingError = result.message || 'Tidak dapat menghitung ongkir. Silakan coba lagi.';
                        }
                    } catch (e) {
                        console.error('Failed to calculate shipping:', e);
                        this.shippingError = 'Gagal menghubungi server shipping. Silakan coba lagi.';
                    } finally {
                        this.loadingShipping = false;
                    }
                },

                selectShipping(index) {
                    this.selectedShipping = this.shippingOptions[index];
                    this.selectedShippingService = this.shippingOptions[index].service;
                },

                addToCart(prod) {
                    this.cart.push({
                        product_id: prod.product_id,
                        name: prod.name,
                        price: prod.price,
                        type: prod.type,
                        weight: prod.weight || 1000,
                        image_url: prod.image_url,
                        icon: prod.icon,
                        qty: 1
                    });
                    
                    // Recalculate shipping if physical products
                    if (prod.type === 'physical' && this.shipping.city_id) {
                        this.calculateShipping();
                    }
                },

                updateQty(index, delta) {
                    const newQty = this.cart[index].qty + delta;
                    if (newQty > 0) {
                        this.cart[index].qty = newQty;
                        
                        // Recalculate shipping if physical products
                        if (this.cart[index].type === 'physical' && this.shipping.city_id) {
                            this.calculateShipping();
                        }
                    }
                },

                removeItem(index) {
                    const wasPhysical = this.cart[index].type === 'physical';
                    if (this.cart.length > 1) {
                        this.cart.splice(index, 1);
                        
                        // Recalculate shipping
                        if (wasPhysical && this.shipping.city_id) {
                            this.calculateShipping();
                        }
                    }
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
                },

                async submitOrder() {
                    // Validate shipping for physical products
                    if (this.hasPhysicalProducts) {
                        // If using profile address, make sure profile has address data
                        if (this.useProfileAddress) {
                            if (!config.user?.city_id || !config.user?.address_detail) {
                                alert('Alamat profile Anda belum lengkap. Silakan lengkapi alamat di halaman profile atau masukkan alamat manual.');
                                return;
                            }
                        } else {
                            // Manual address - validate all fields
                            if (!this.shipping.province_id || !this.shipping.city_id || !this.shipping.address) {
                                alert('Mohon lengkapi alamat pengiriman.');
                                return;
                            }
                        }
                        if (!this.selectedShipping) {
                            alert('Mohon tunggu hingga ongkir selesai dihitung.');
                            return;
                        }
                    }

                    if (this.settings.require_login_checkout === '1' && !config.isLoggedIn) {
                        window.location.href = config.loginUrl + '?redirect=' + encodeURIComponent(window.location.href);
                        return;
                    }

                    this.loading = true;
                    try {
                        const response = await fetch('{{ route('checkout.process', ['productId' => $product->product_id]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart: this.cart,
                                buyer: this.buyer,
                                shipping: this.hasPhysicalProducts ? {
                                    province_id: this.shipping.province_id,
                                    city_id: this.shipping.city_id,
                                    address: this.shipping.address,
                                    courier: 'jnt',
                                    service: this.selectedShipping?.service,
                                    cost: this.selectedShipping?.cost,
                                    etd: this.selectedShipping?.etd
                                } : null
                            })
                        });

                        const result = await response.json();
                        if (result.success && result.payment_link) {
                            window.location.href = result.payment_link;
                        } else {
                            alert(result.message || 'Terjadi kesalahan saat memproses pesanan.');
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Gagal menghubungi server.');
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>