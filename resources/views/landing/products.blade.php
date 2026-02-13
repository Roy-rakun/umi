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
<div class="py-16 px-4 bg-white" x-data="{ open: false, product: {} }">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
            <div class="card-soft rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-red-50 flex flex-col h-full bg-white">
                <div class="aspect-square bg-gradient-to-br from-rose-50 to-amber-50 relative flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity overflow-hidden"
                     @click="open = true; product = {{ json_encode($product) }}">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @elseif($product->icon)
                        <iconify-icon icon="{{ $product->icon }}" class="text-5xl text-primary/60"></iconify-icon>
                    @else
                        <span class="text-5xl">@if($product->type == 'physical') 📿 @else 🎓 @endif</span>
                    @endif
                </div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <div class="text-[10px] text-amber-600 font-bold mb-2 uppercase tracking-[0.2em]">{{ $product->type == 'physical' ? 'Produk Fisik' : 'Kelas Digital' }}</div>
                    <h3 class="font-serif text-xl font-bold text-heading mb-3 leading-tight min-h-[50px] cursor-pointer hover:text-primary transition-colors"
                        @click="open = true; product = {{ json_encode($product) }}">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow">{{ $product->description }}</p>
                    
                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-primary font-serif font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        
                        <a href="{{ route('checkout', $product->product_id) }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#5D2228] transition-all transform hover:-translate-y-1">
                            {{ $product->type == 'physical' ? 'Beli Sekarang' : 'Daftar Sekarang' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Detail Modal -->
    <template x-teleport="body">
    <div x-show="open" 
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        
        <div @click.away="open = false" 
            class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl relative"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0">
        
        <button @click="open = false" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors z-10">
            <i class="fas fa-times"></i>
        </button>

        <div class="grid md:grid-cols-2">
            <div class="aspect-square bg-gradient-to-br from-rose-100 to-amber-50 flex items-center justify-center text-7xl overflow-hidden">
                <template x-if="product.image_url">
                    <img :src="'/storage/' + product.image_url.replace('/storage/', '')" :alt="product.name" class="w-full h-full object-cover">
                </template>
                <template x-if="!product.image_url">
                    <span x-text="product.type == 'physical' ? '📿' : '🎓'"></span>
                </template>
            </div>
            <div class="p-8 flex flex-col">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-600 mb-2" x-text="product.type == 'physical' ? 'Produk Fisik' : 'Kelas Digital'"></span>
                <h2 class="font-serif text-2xl md:text-3xl font-bold mb-4 text-heading" x-text="product.name"></h2>
                <div class="flex-1 overflow-y-auto max-h-60 mb-6 text-sm leading-relaxed text-gray-600" x-text="product.description"></div>
                
                <div class="mt-auto border-t pt-6 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-xs opacity-50 uppercase">Harga</span>
                        <span class="font-serif text-2xl font-bold text-primary" x-text="'Rp ' + (product.price ? product.price.toLocaleString('id-ID') : '0')"></span>
                    </div>
                    <a :href="'/checkout/' + product.product_id" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-[#5D2228] transition-all">
                        <span x-text="product.type == 'physical' ? 'Beli Sekarang' : 'Daftar Sekarang'"></span>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
    </template>
</div>

<style>
    .card-soft {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
    }
</style>
@endsection
