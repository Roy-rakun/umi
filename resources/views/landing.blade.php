@extends('layouts.app')

@section('content')
<!-- SECTION 1: HERO -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden px-4">
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-red-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
    </div>

    <div class="text-center relative z-10 max-w-3xl mx-auto pt-10 md:pt-20">
        <!-- Logo -->
        <div class="mb-8 flex justify-center">
            <div class="w-32 md:w-48">
                <img src="{{ asset('Logo.png') }}" alt="The Secret Logo" class="w-full h-auto drop-shadow-xl">
            </div>
        </div>
        
        <p class="text-primary text-xs md:text-sm uppercase tracking-widest mb-4 font-medium">Assalamu'alaikum warahmatullahi wabarakatuh</p>
        
        <h1 class="text-5xl md:text-7xl font-serif text-heading mb-2">The Secret</h1>
        <h2 class="text-2xl md:text-3xl font-serif text-primary/80 italic mb-8">by Umy Fadillaa</h2>
        
        <p class="text-gray-600 text-lg leading-relaxed mb-10 max-w-2xl mx-auto font-light">
            Discover the path to inner peace and spiritual growth. A sacred space where intention meets transformation, guiding you towards a life filled with purpose, clarity, and divine connection.
        </p>
        
        <a href="#products" class="btn-maroon px-8 py-4 rounded-lg font-medium inline-flex items-center text-lg shadow-lg">
            <span>Begin Your Journey</span>
        </a>
        
        <div class="mt-16 text-primary animate-bounce">
            <a href="#products"><i class="fas fa-arrow-down text-xl opacity-50"></i></a>
        </div>
    </div>
</section>

<!-- SECTION 3: SOCIALS -->
<section class="py-16 bg-white/50">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-serif text-heading mb-12">Connect With Me</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- TikTok -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-pink-50 group">
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-pink-100 transition-colors">
                    <i class="fab fa-tiktok text-2xl text-primary"></i>
                </div>
                <h3 class="font-serif text-xl mb-1">TikTok</h3>
                <p class="text-xs text-gray-500 mb-6">@thesecretbyumy</p>
                <a href="{{ $settings['social_tiktok'] ?? '#' }}" target="_blank" class="text-primary font-medium hover:underline text-sm">Follow ></a>
            </div>
            
            <!-- Instagram -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-pink-50 group">
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-pink-100 transition-colors">
                    <i class="fab fa-instagram text-2xl text-primary"></i>
                </div>
                <h3 class="font-serif text-xl mb-1">Instagram</h3>
                <p class="text-xs text-gray-500 mb-6">@thesecretbyumy</p>
                <a href="{{ $settings['social_instagram'] ?? '#' }}" target="_blank" class="text-primary font-medium hover:underline text-sm">Follow ></a>
            </div>
            
            <!-- YouTube -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-pink-50 group">
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-pink-100 transition-colors">
                    <i class="fab fa-youtube text-2xl text-primary"></i>
                </div>
                <h3 class="font-serif text-xl mb-1">YouTube</h3>
                <p class="text-xs text-gray-500 mb-6">The Secret by Umy</p>
                <a href="{{ $settings['social_youtube'] ?? '#' }}" target="_blank" class="text-primary font-medium hover:underline text-sm">Subscribe ></a>
            </div>
        </div>

        <div class="flex items-center justify-center text-primary/80 font-medium text-sm">
             <i class="fas fa-check-circle mr-2"></i> Official & Verified Accounts
        </div>
    </div>
</section>

<!-- SECTION 4: PRODUCTS -->
<section id="products" class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-primary text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2 mb-2">
                EXCLUSIVE COLLECTION
            </span>
            <h2 class="text-4xl font-serif text-heading mb-4">Sacred Offerings</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Carefully curated products and experiences designed to elevate your spiritual journey</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-pink-50 group flex flex-col h-full">
                <!-- Product Image -->
                <div class="h-48 bg-pink-50 relative flex items-center justify-center group-hover:bg-pink-100 transition-colors overflow-hidden">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @elseif($product->icon)
                        <iconify-icon icon="{{ $product->icon }}" class="text-5xl text-primary/60"></iconify-icon>
                    @else
                        <i class="fas fa-box-open text-primary/30 text-4xl"></i>
                    @endif
                    
                    @if($loop->iteration == 1)
                        <span class="absolute top-3 left-3 bg-[#7D2E35] text-white text-[10px] uppercase font-bold px-2 py-1 rounded">Popular</span>
                    @elseif($loop->iteration == 2)
                         <span class="absolute top-3 right-3 border border-primary text-primary text-[10px] uppercase font-bold px-2 py-1 rounded">New</span>
                    @endif
                </div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <div class="text-xs text-primary/60 font-medium mb-1 uppercase tracking-wide">{{ $product->category ?? 'General' }}</div>
                    <h3 class="font-serif text-lg font-bold text-heading mb-2 leading-tight min-h-[50px]">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-3 flex-grow">{{ $product->description ?? 'Transform your life through sacred knowledge.' }}</p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-heading font-serif font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        
                        <a href="{{ route('checkout', $product->product_id) }}" class="bg-[#7D2E35] text-white px-6 py-2 rounded text-sm hover:bg-[#5D2228] transition-colors">
                            {{ $product->type == 'physical' ? 'Shop' : 'Enroll' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="inline-block px-10 py-3 rounded-md border border-[#7D2E35] text-[#7D2E35] hover:bg-[#7D2E35] hover:text-white transition-colors text-sm font-medium">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- SECTION 5: AFFILIATE CTA -->
<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#7D2E35] rounded-3xl p-10 md:p-12 text-center text-white relative overflow-hidden">
            <!-- Details -->
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="far fa-star text-2xl"></i>
                </div>
                
                <h2 class="text-3xl md:text-4xl font-serif mb-4">Become Part of Our Mission</h2>
                <p class="text-white/80 max-w-2xl mx-auto mb-8 leading-relaxed font-light text-sm md:text-base">
                    Join our blessed affiliate family and share the gift of spiritual growth with others. 
                    Earn meaningful rewards while spreading positive change in the world. This is more than business—it's a sacred partnership built on trust, integrity, and shared values.
                </p>
                
                <div class="flex flex-wrap justify-center gap-4 text-xs md:text-sm mb-8">
                    <span class="bg-white/10 px-4 py-1 rounded-full"><i class="fas fa-check mr-2"></i> Ethical Commission</span>
                    <span class="bg-white/10 px-4 py-1 rounded-full"><i class="fas fa-check mr-2"></i> Exclusive Training</span>
                    <span class="bg-white/10 px-4 py-1 rounded-full"><i class="fas fa-check mr-2"></i> Supportive Community</span>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-primary px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors text-sm">
                        Join Affiliate Program
                    </a>
                    <a href="{{ route('login') }}" class="border border-white/50 text-white px-6 py-3 rounded-lg font-medium hover:bg-white/10 transition-colors text-sm">
                        Affiliate Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

