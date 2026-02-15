@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_id)
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders') }}" class="text-primary hover:underline text-sm">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-shopping-bag text-primary"></i>
                Informasi Pesanan
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">ID Pesanan</p>
                    <p class="font-bold text-heading">#{{ $order->order_id }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Tanggal</p>
                    <p class="font-bold text-heading">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Status Pembayaran</p>
                    @if($order->payment_status == 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Dibayar</span>
                    @elseif($order->payment_status == 'pending')
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Tertunda</span>
                    @elseif($order->payment_status == 'cancelled')
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">Dibatalkan</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">{{ $order->payment_status }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Metode Pembayaran</p>
                    <p class="font-bold text-heading">{{ $order->payment_method ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-box text-primary"></i>
                Produk yang Dipesan
            </h3>
            <div class="space-y-4">
                @if($order->items->count() > 0)
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <i class="fas fa-box text-gray-300 text-xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-heading">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-bold text-heading">{{ $order->product->name ?? 'Produk' }}</p>
                        <p class="text-sm text-gray-500">Jumlah: 1</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
        @if($order->shipping_details)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-truck text-primary"></i>
                Alamat Pengiriman
            </h3>
            <?php $shipping = is_string($order->shipping_details) ? json_decode($order->shipping_details, true) : $order->shipping_details; ?>
            @if($shipping)
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg space-y-3">
                <div class="flex items-start gap-3">
                    <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                    <div>
                        <p class="font-bold text-heading">Alamat Lengkap</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $shipping['address'] ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 pt-3 border-t border-blue-200">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Provinsi ID</p>
                        <p class="text-sm font-medium">{{ $shipping['province_id'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Kota ID</p>
                        <p class="text-sm font-medium">{{ $shipping['city_id'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Kurir</p>
                        <p class="text-sm font-medium">{{ $shipping['courier'] ?? 'J&T Express' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Layanan</p>
                        <p class="text-sm font-medium">{{ $shipping['service'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Estimasi</p>
                        <p class="text-sm font-medium">{{ ($shipping['etd'] ?? '-') . ' hari' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Ongkir</p>
                        <p class="text-sm font-bold text-primary">Rp {{ number_format($order->shipping_cost ?? ($shipping['cost'] ?? 0), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @else
            <p class="text-gray-400 italic">Tidak ada data pengiriman</p>
            @endif
        </div>
        @endif
    </div>

    <!-- Buyer & Payment Summary -->
    <div class="space-y-6">
        <!-- Buyer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-user text-primary"></i>
                Informasi Pembeli
            </h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Nama</p>
                    <p class="font-bold text-heading">{{ $order->buyer_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                    <p class="text-sm text-gray-600">{{ $order->buyer_email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Telepon</p>
                    <p class="text-sm text-gray-600">{{ $order->buyer_phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-receipt text-primary"></i>
                Ringkasan Pembayaran
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($order->amount - ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                </div>
                @if($order->shipping_cost && $order->shipping_cost > 0)
                <div class="flex justify-between">
                    <span class="text-gray-500">Ongkos Kirim</span>
                    <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="border-t border-gray-200 pt-3 flex justify-between">
                    <span class="font-bold text-heading">Total</span>
                    <span class="font-bold text-primary text-lg">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Affiliate Info -->
        @if($order->affiliate)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <i class="fas fa-users text-primary"></i>
                Referral Affiliate
            </h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Nama Affiliate</p>
                    <p class="font-bold text-heading">{{ $order->affiliate->user->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Kode Referral</p>
                    <p class="text-sm text-gray-600">{{ $order->affiliate_ref }}</p>
                </div>
                @if($order->commission)
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Komisi</p>
                    <p class="text-sm font-bold text-primary">Rp {{ number_format($order->commission->commission_amount, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-heading mb-4">Aksi</h3>
            <div class="space-y-3">
                @if($order->payment_status != 'cancelled' && $order->payment_status != 'failed')
                    <form action="{{ route('admin.orders.cancel', $order->order_id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg text-sm font-bold hover:bg-orange-600 transition-colors">
                            <i class="fas fa-times mr-2"></i> Batalkan Pesanan
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg text-sm font-bold hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash mr-2"></i> Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection