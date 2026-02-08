@extends('layouts.affiliate')

@section('title')
    <div class="flex flex-col">
        <h2 class="text-xl font-serif font-bold text-[#2C3E50]">My Affiliate Links</h2>
        <p class="text-xs text-gray-400">Manage and create your promotion links</p>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ 
    selectedProduct: '', 
    baseUrl: '{{ $referralLink }}',
    get promoLink() {
        const link = this.selectedProduct ? this.baseUrl + '?product=' + this.selectedProduct : this.baseUrl;
        console.log('Generated promo link:', link, 'Selected product:', this.selectedProduct);
        return link;
    }
}" x-init="console.log('Alpine.js initialized on My Links page', 'Base URL:', baseUrl)">
    <!-- Link Generator -->
    <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50 mb-10">
        <div class="flex items-start mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-5">
                <i class="fas fa-magic text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Default Referral Link</h3>
                <p class="text-xs text-gray-400 font-medium tracking-wide">Share this general link to track all activities</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4 mb-8">
            <div class="flex-1 bg-gray-50 border border-gray-100 rounded-2xl p-4 text-gray-500 font-mono text-sm overflow-hidden whitespace-nowrap relative">
                <span x-text="promoLink"></span>
            </div>
            <button @click="navigator.clipboard.writeText(promoLink); alert('Link copied to clipboard!')" 
                    class="bg-[#7D2E35] hover:bg-[#632429] text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg flex items-center">
                <i class="far fa-copy mr-2"></i> Copy Link
            </button>
        </div>

        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Generate link for specific product:</p>
        <div class="flex flex-wrap gap-2">
            <button @click="selectedProduct = ''" 
                    :class="selectedProduct === '' ? 'bg-[#7D2E35] text-white' : 'bg-white text-gray-500 border border-gray-100 hover:border-[#7D2E35]'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all">
                Default Link
            </button>
            @foreach($products as $product)
            <button @click="selectedProduct = '{{ Str::slug($product->name) }}'" 
                    :class="selectedProduct === '{{ Str::slug($product->name) }}' ? 'bg-[#7D2E35] text-white' : 'bg-white text-gray-500 border border-gray-100 hover:border-[#7D2E35]'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all">
                {{ $product->name }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Active Promotion Links (Dummy for now to match consistency) -->
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Active Promotion Links</h3>
            <p class="text-xs text-gray-400 font-medium tracking-wide">Links specifically generated for campaigns</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Campaign Name</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Clicks</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Sales</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Link</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr>
                        <td colspan="4" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-200 mb-4">
                                    <i class="fas fa-link text-3xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-bold">No custom links generated yet</p>
                                <p class="text-[10px] text-gray-400 max-w-xs mt-2">Use the generator on your dashboard to create product-specific links.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Link copied to clipboard!');
        });
    }
</script>
@endsection
