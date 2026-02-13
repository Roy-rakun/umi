@extends('layouts.affiliate')

@section('title')
    <div class="flex flex-col">
        <h2 class="text-xl font-serif font-bold text-[#2C3E50]">Riwayat Komisi</h2>
        <p class="text-xs text-gray-400">Lihat semua komisi yang telah Anda dapatkan</p>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Summary Header -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-50 flex items-center">
            <div class="w-12 h-12 rounded-xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-4">
                <i class="fas fa-coins text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Diperoleh</p>
                <h3 class="text-xl font-bold text-[#2C3E50]">Rp {{ number_format($affiliate->total_commission, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Riwayat Detail</h3>
            <p class="text-xs text-gray-400 font-medium tracking-wide">Semua catatan komisi sejak bergabung</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Produk</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">ID Pesanan</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Nilai Pesanan</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Komisi</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($commissions as $commission)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-[#2C3E50]">{{ $commission->created_at->format('d M Y') }}</p>
                            <p class="text-[9px] text-gray-400 font-medium">{{ $commission->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-8 py-6 text-xs font-bold text-[#2C3E50]">
                            {{ $commission->order->product->name ?? 'Produk Dihapus' }}
                        </td>
                        <td class="px-8 py-6 text-xs font-medium text-gray-400">
                            #{{ $commission->order_id }}
                        </td>
                        <td class="px-8 py-6 text-xs font-bold text-gray-500">
                            Rp {{ number_format($commission->order->amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6 text-xs font-bold text-[#7D2E35]">
                            Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-[9px] font-bold rounded-lg 
                                {{ $commission->status == 'paid' ? 'bg-[#F0FFF4] text-[#27AE60]' : 
                                   ($commission->status == 'approved' ? 'bg-[#F0F7FF] text-[#2980B9]' : 
                                   ($commission->status == 'pending' ? 'bg-[#FFF9F0] text-[#F39C12]' : 'bg-red-50 text-red-500')) }}">
                                {{ $commission->status == 'paid' ? 'Dibayar' : ($commission->status == 'approved' ? 'Disetujui' : ($commission->status == 'pending' ? 'Tertunda' : ucfirst($commission->status))) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-200 mb-4">
                                    <i class="fas fa-inbox text-3xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-bold">Tidak ada data ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($commissions->hasPages())
        <div class="p-8 border-t border-gray-50">
            {{ $commissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection