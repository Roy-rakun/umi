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
        loginUrl: '{{ route('login') }}'
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
            </div>

            <!-- Right Column: Buyer Info & Summary -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Buyer Form -->
                <div class="bg-white rounded-3xl shadow-sm border border-pink-100 p-8">
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
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-sm">Biaya Layanan</span>
                                <span class="text-primary text-xs font-bold uppercase tracking-widest">Gratis</span>
                            </div>
                            <div class="flex justify-between items-center mb-8">
                                <span class="text-primary font-heading font-bold text-lg">Total</span>
                                <span class="text-primary font-heading font-bold text-2xl" x-text="formatPrice(totalPrice)"></span>
                            </div>

                            <button type="submit" :disabled="loading" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-900/20 hover:bg-red-900 transition-all flex items-center justify-center gap-3 disabled:opacity-50">
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
                cart: [],
                allProducts: config.allProducts,
                settings: config.settings,
                buyer: {
                    name: '{{ auth()->user()->name ?? '' }}',
                    email: '{{ auth()->user()->email ?? '' }}',
                    phone: '{{ auth()->user()->phone ?? '' }}',
                },
                loading: false,

                init() {
                    const initial = config.initialProduct;
                    this.cart.push({
                        product_id: initial.product_id,
                        name: initial.name,
                        price: initial.price,
                        type: initial.type,
                        image_url: initial.image_url,
                        icon: initial.icon,
                        qty: 1
                    });
                },

                get availableProducts() {
                    return this.allProducts.filter(p => !this.cart.some(c => c.product_id === p.product_id));
                },

                get totalPrice() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                addToCart(prod) {
                    this.cart.push({
                        product_id: prod.product_id,
                        name: prod.name,
                        price: prod.price,
                        type: prod.type,
                        image_url: prod.image_url,
                        icon: prod.icon,
                        qty: 1
                    });
                },

                updateQty(index, delta) {
                    const newQty = this.cart[index].qty + delta;
                    if (newQty > 0) {
                        this.cart[index].qty = newQty;
                    }
                },

                removeItem(index) {
                    if (this.cart.length > 1) {
                        this.cart.splice(index, 1);
                    }
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
                },

                async submitOrder() {
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
                                buyer: this.buyer
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
捉
