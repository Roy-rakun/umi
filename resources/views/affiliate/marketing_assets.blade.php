@extends('layouts.affiliate')
@section('title', 'Marketing Assets')
@section('content')
<div class="max-w-7xl mx-auto" x-data="{ 
    selectedProduct: '', 
    baseUrl: '{{ url('/ref/' . auth()->user()->affiliate?->referral_code) }}',
    get promoLink() {
        return this.selectedProduct ? this.baseUrl + '?product=' + this.selectedProduct : this.baseUrl;
    },
    copyLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            alert('Link berhasil disalin!');
        });
    }
}">
    <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50 mb-10">
        <div class="flex items-start mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-5">
                <i class="fas fa-box-open text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Daftar Produk & Link Affiliate</h3>
                <p class="text-xs text-gray-400 font-medium tracking-wide">Pilih produk untuk mendapatkan link promosi khusus</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="aspect-video bg-gray-100 rounded-xl mb-4 flex items-center justify-center text-gray-400 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-image text-3xl opacity-20"></i>
                    @endif
                </div>
                <h4 class="font-bold text-[#2C3E50] mb-2">{{ $product->name }}</h4>
                <p class="text-[10px] font-bold text-[#7D2E35] uppercase tracking-widest mb-4">
                    Komisi: {{ $product->commission_rate }}%
                </p>
                
                <div class="space-y-3">
                    <button @click="copyLink(baseUrl + '?product={{ Str::slug($product->name) }}')" 
                            class="w-full bg-[#7D2E35] text-white py-3 rounded-xl text-xs font-bold hover:bg-[#632429] transition-colors flex items-center justify-center">
                        <i class="far fa-copy mr-2"></i> Salin Link
                    </button>
                    <a href="{{ route('checkout', $product->product_id) }}" target="_blank" class="block text-center w-full border border-gray-100 text-gray-400 py-3 rounded-xl text-xs font-bold hover:border-[#7D2E35] hover:text-[#7D2E35] transition-all">
                        Lihat Produk
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
@endsection
