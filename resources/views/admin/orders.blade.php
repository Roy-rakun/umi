@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Daftar Pesanan</h3>
            <p class="text-sm text-gray-500">Lacak dan kelola pesanan pelanggan.</p>
        </div>
        <div class="flex space-x-2">
            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-download mr-2"></i> Ekspor
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ref Affiliate</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-heading">
                            #{{ $order->order_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-heading">{{ $order->buyer_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->buyer_email }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600">
                            {{ $order->product->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($order->affiliate)
                                <div class="text-xs font-medium text-primary">{{ $order->affiliate->user->name ?? 'Tidak Dikenal' }}</div>
                                <div class="text-[10px] text-gray-400">Ref: {{ $order->affiliate_ref }}</div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-heading">
                            Rp {{ number_format($order->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($order->payment_status == 'paid')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Dibayar</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Tertunda</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">{{ $order->payment_status == 'failed' ? 'Gagal' : $order->payment_status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-gray-500">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $orders->links() }}
        </div>
    </div>
@endsection