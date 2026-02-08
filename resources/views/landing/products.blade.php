@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="bg-[#FFF9F9] py-12 md:py-20 text-center border-b border-pink-100">
    <div class="max-w-4xl mx-auto px-4">
        <p class="text-primary text-xs md:text-sm uppercase tracking-widest mb-2 font-medium">THE SECRET COLLECTION</p>
        <h1 class="text-3xl md:text-5xl font-serif text-heading mb-4">Sacred Offerings</h1>
        <p class="text-gray-500 max-w-lg mx-auto">Explore our complete collection of spiritual tools and knowledge designed to elevate your journey.</p>
    </div>
</div>

<!-- Products Grid -->
<div class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-pink-50 group flex flex-col h-full">
                <!-- Image Placeholder -->
                <div class="h-48 bg-pink-50 relative flex items-center justify-center group-hover:bg-pink-100 transition-colors">
                    <i class="fas fa-box-open text-primary/30 text-4xl"></i>
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
    </div>
</div>
@endsection
