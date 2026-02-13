@extends('layouts.affiliate')

@section('title')
    <div class="flex flex-col">
        <h2 class="text-xl font-serif font-bold text-[#2C3E50]">Dasbor Saya</h2>
        <p class="text-xs text-gray-400">Pantau performa affiliate Anda</p>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ 
    selectedProduct: '', 
    baseUrl: '{{ $referralLink }}',
    get promoLink() {
        return this.selectedProduct ? this.baseUrl + '?product=' + this.selectedProduct : this.baseUrl;
    }
}">
    <!-- Header dengan Tanggal -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <!-- Breadcrumb or Subtitle already handled in layout/title section -->
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mr-2 text-right">Hari Ini:</span>
            <span class="text-xs font-bold text-[#7D2E35]">{{ date('d M Y') }}</span>
        </div>
    </div>

    <!-- Banner Selamat Datang -->
    <div class="relative bg-[#7D2E35] rounded-[2rem] p-10 text-white mb-10 overflow-hidden shadow-2xl group">
        <!-- Dekorasi Bintang -->
        <div class="absolute right-10 top-1/2 -translate-y-1/2 opacity-10 transition-transform duration-700 group-hover:rotate-12">
            <i class="fas fa-star text-[12rem]"></i>
        </div>
        <div class="relative z-10">
            <div class="flex items-center mb-4">
                <i class="fas fa-rocket text-[#E8D5B5] mr-3 text-sm"></i>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70">Selamat datang kembali</span>
            </div>
            <h1 class="font-serif text-3xl md:text-4xl font-bold mb-4 leading-tight">
                Selamat datang, semoga usahamu <span class="italic text-[#E8D5B5]">bermakna dan diberkahi.</span>
            </h1>
            <p class="text-white/80 text-sm max-w-xl font-medium leading-relaxed">
                Dasbor Anda siap. Pantau kemajuan Anda dan terus berkembang dengan integritas.
            </p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Penghasilan -->
        <div class="bg-surface rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-4">
                <i class="fas fa-coins text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Penghasilan</p>
                <h3 class="text-xl font-bold text-[#2C3E50]">Rp {{ number_format($totalEarnings/1000000, 1) }}Jt</h3>
            </div>
        </div>

        <!-- Total Klik -->
        <div class="bg-surface rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-[#F0F7FF] flex items-center justify-center text-[#2980B9] mr-4">
                <i class="fas fa-mouse-pointer text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Klik</p>
                <h3 class="text-xl font-bold text-[#2C3E50]">{{ number_format($totalClicks) }}</h3>
            </div>
        </div>

        <!-- Pesanan Berhasil -->
        <div class="bg-surface rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-[#F0FFF4] flex items-center justify-center text-[#27AE60] mr-4">
                <i class="fas fa-shopping-bag text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pesanan Berhasil</p>
                <h3 class="text-xl font-bold text-[#2C3E50]">{{ number_format($successfulOrders) }}</h3>
            </div>
        </div>

        <!-- Saldo Tersedia -->
        <div class="bg-surface rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-[#FFF9F0] flex items-center justify-center text-[#F39C12] mr-4">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Saldo Tersedia</p>
                <h3 class="text-xl font-bold text-[#2C3E50]">Rp {{ number_format($availableBalance/1000000, 1) }}Jt</h3>
            </div>
        </div>
    </div>

    <!-- Generator Link -->
    <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50 mb-10">
        <div class="flex items-start mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-5">
                <i class="fas fa-link text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Link Affiliate Anda</h3>
                <p class="text-xs text-gray-400 font-medium tracking-wide">Bagikan link ini untuk mendapatkan komisi</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4 mb-8">
            <div class="flex-1 bg-gray-50 border border-gray-100 rounded-2xl p-4 text-gray-500 font-mono text-sm overflow-hidden whitespace-nowrap relative">
                <span x-text="promoLink"></span>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300">
                    <i class="fas fa-italic text-[10px]"></i>
                </div>
            </div>
            <button class="bg-[#7D2E35] hover:bg-[#632429] text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg flex items-center"
                    @click="navigator.clipboard.writeText(promoLink); alert('Link berhasil disalin!');">
                <i class="far fa-copy mr-2"></i> Salin Link
            </button>
        </div>

        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Buat link untuk produk tertentu:</p>
        <div class="flex flex-wrap gap-2">
            <button @click="selectedProduct = ''" 
                    :class="selectedProduct === '' ? 'bg-[#7D2E35] text-white' : 'bg-white text-gray-500 border border-gray-100 hover:border-[#7D2E35]'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all">
                Link Utama
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

    <!-- Riwayat Komisi -->
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Riwayat Komisi</h3>
                <p class="text-xs text-gray-400 font-medium tracking-wide">Pantau penghasilan Anda secara transparan</p>
            </div>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="bg-white border border-gray-100 px-4 py-2 rounded-xl text-[10px] font-bold text-gray-500 flex items-center hover:border-gray-200 transition-colors">
                    Semua Status <i class="fas fa-chevron-down ml-2 text-[8px]"></i>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Produk</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Nilai Pesanan</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Komisi</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentCommissions as $commission)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-[#2C3E50] mb-1">{{ $commission->created_at->format('d M Y') }}</p>
                            <p class="text-[9px] text-gray-400 font-medium">{{ $commission->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-[#2C3E50]">{{ $commission->order->product->name ?? 'Tidak Dikenal' }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-gray-500">Rp {{ number_format($commission->order->amount ?? 0, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-[#7D2E35]">Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-[9px] font-bold rounded-lg 
                                {{ $commission->status == 'paid' ? 'bg-[#F0FFF4] text-[#27AE60]' : 
                                   ($commission->status == 'approved' ? 'bg-[#F0F7FF] text-[#2980B9]' : 
                                   ($commission->status == 'pending' ? 'bg-[#FFF9F0] text-[#F39C12]' : 'bg-red-50 text-red-500')) }}">
                                {{ $commission->status == 'paid' ? 'Dicairkan' : 
                                   ($commission->status == 'approved' ? 'Disetujui' : 
                                   ($commission->status == 'pending' ? 'Tertunda' : 'Ditolak')) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-200 mb-4">
                                    <i class="fas fa-inbox text-3xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-bold">Belum ada riwayat komisi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-gray-50 flex items-center justify-between">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Menampilkan 1-{{ $recentCommissions->count() }} dari {{ $recentCommissions->count() }} hasil</p>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chevron-left text-[8px]"></i>
                </button>
                <button class="w-8 h-8 rounded-lg bg-[#7D2E35] text-white font-bold text-[10px] shadow-sm">1</button>
                <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-400 font-bold text-[10px] hover:border-gray-200 transition-colors">2</button>
                <button class="w-8 h-8 rounded-lg bg-white border border-gray-100 text-gray-400 font-bold text-[10px] hover:border-gray-200 transition-colors">3</button>
                <button class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chevron-right text-[8px]"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection