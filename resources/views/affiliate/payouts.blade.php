@extends('layouts.affiliate')

@section('title')
    <div class="flex flex-col">
        <h2 class="text-xl font-serif font-bold text-[#2C3E50]">Pencairan Dana</h2>
        <p class="text-xs text-gray-400">Kelola penghasilan dan pencairan dana Anda</p>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Request Section -->
        <div class="lg:col-span-2">
            <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50 h-full">
                <div class="flex items-start mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-[#FFF9F0] flex items-center justify-center text-[#F39C12] mr-5">
                        <i class="fas fa-money-bill-wave text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Ajukan Pencairan</h3>
                        <p class="text-xs text-gray-400 font-medium tracking-wide">Cairkan komisi yang telah disetujui</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Saldo Tersedia</p>
                    <h2 class="text-3xl font-bold text-[#7D2E35]">Rp {{ number_format($availableBalance, 0, ',', '.') }}</h2>
                </div>

                <form action="{{ route('affiliate.payouts.request') }}" method="POST">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex-1 w-full">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Jumlah Pencairan</label>
                            <input type="text" value="Rp {{ number_format($availableBalance, 0, ',', '.') }}" disabled class="w-full bg-white border border-gray-100 px-5 py-4 rounded-2xl text-sm font-bold text-[#2C3E50] focus:outline-none">
                        </div>
                        <div class="w-full md:w-auto pt-6">
                            <button type="submit" class="w-full bg-[#7D2E35] hover:bg-[#632429] text-white px-10 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg">
                                Cairkan Sekarang
                            </button>
                        </div>
                    </div>
                    <p class="mt-4 text-[10px] text-gray-400 italic">Minimal pencairan Rp 100.000. Semua pencairan diproses dalam 3-5 hari kerja.</p>
                </form>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50">
            <div class="flex items-start mb-8">
                <div class="w-12 h-12 rounded-2xl bg-[#F0F7FF] flex items-center justify-center text-[#2980B9] mr-5">
                    <i class="fas fa-university text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Rekening Bank</h3>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">Tujuan transfer dana</p>
                </div>
            </div>

                <div class="space-y-6">
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Info Rekening Bank</p>
                    <p class="text-sm font-bold text-[#2C3E50]">{{ auth()->user()->bank_account ?? 'Silakan lengkapi di profil' }}</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-2xl border border-dashed border-gray-300">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 italic text-center">Admin akan mengirim ke rekening di atas</p>
                </div>
                <a href="{{ route('affiliate.profile') }}" class="block text-center w-full border border-gray-100 text-gray-400 py-4 rounded-2xl font-bold text-xs hover:border-[#7D2E35] hover:text-[#7D2E35] transition-all">
                    Ubah Rekening Bank
                </a>
            </div>
        </div>
    </div>

    <!-- Payout History Table -->
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Riwayat Pencairan</h3>
            <p class="text-xs text-gray-400 font-medium tracking-wide">Semua permintaan pembayaran sebelumnya</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Referensi</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Jumlah</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payouts as $payout)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-[#2C3E50]">{{ $payout->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-8 py-6 text-xs font-medium text-gray-400">
                            #{{ $payout->payout_id }}
                        </td>
                        <td class="px-8 py-6 text-xs font-bold text-[#2C3E50]">
                            Rp {{ number_format($payout->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 inline-flex text-[9px] font-bold rounded-lg 
                                {{ $payout->status == 'completed' ? 'bg-[#F0FFF4] text-[#27AE60]' : 
                                   ($payout->status == 'pending' ? 'bg-[#FFF9F0] text-[#F39C12]' : 
                                   ($payout->status == 'approved' ? 'bg-[#F0F7FF] text-[#2980B9]' : 'bg-red-50 text-red-500')) }}">
                                {{ $payout->status == 'completed' ? 'Selesai' : ($payout->status == 'pending' ? 'Tertunda' : ($payout->status == 'approved' ? 'Disetujui' : ($payout->status == 'rejected' ? 'Ditolak' : ucfirst($payout->status)))) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-200 mb-4">
                                    <i class="fas fa-history text-3xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-bold">Belum ada riwayat pencairan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payouts->hasPages())
        <div class="p-8 border-t border-gray-50">
            {{ $payouts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection