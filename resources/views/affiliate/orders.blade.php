@extends('layouts.affiliate')
@section('title', 'Pesanan Saya')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-heading font-bold text-primary">Pesanan Saya</h2>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-pink-50/30 rounded-xl p-4 border border-pink-100 hover:shadow-md transition-shadow cursor-pointer" 
                     onclick="showOrderDetail('{{ $order->order_id }}')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-800">{{ $order->order_id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-primary">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 
                                   ($order->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($order->payment_status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                @if($order->payment_status == 'paid')
                                    <i class="fas fa-check-circle mr-1"></i> Lunas
                                @elseif($order->payment_status == 'pending')
                                    <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                                @elseif($order->payment_status == 'cancelled')
                                    <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                                @else
                                    {{ ucfirst($order->payment_status) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-shopping-bag mr-1"></i> {{ $order->items->count() }} item</span>
                        @if($order->shipping_cost > 0)
                            <span><i class="fas fa-truck mr-1"></i> Ongkir: Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada pesanan</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-red-800 transition-colors">
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>

<!-- Order Detail Modal -->
<div id="orderModal" class="fixed inset-0 bg-gray-500/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold text-primary">Detail Pesanan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="orderContent">
                <div class="flex items-center justify-center py-8">
                    <i class="fas fa-circle-notch fa-spin text-primary text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getStatusBadge(status) {
        let badgeClass = '';
        let icon = '';
        let text = '';
        
        switch(status) {
            case 'paid':
                badgeClass = 'bg-green-100 text-green-800';
                icon = 'fa-check-circle';
                text = 'Lunas';
                break;
            case 'pending':
                badgeClass = 'bg-yellow-100 text-yellow-800';
                icon = 'fa-clock';
                text = 'Menunggu Pembayaran';
                break;
            case 'cancelled':
                badgeClass = 'bg-red-100 text-red-800';
                icon = 'fa-times-circle';
                text = 'Dibatalkan';
                break;
            default:
                badgeClass = 'bg-gray-100 text-gray-800';
                icon = 'fa-question-circle';
                text = status.charAt(0).toUpperCase() + status.slice(1);
        }
        
        return `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${badgeClass}"><i class="fas ${icon} mr-1"></i> ${text}</span>`;
    }
    
    function showOrderDetail(orderId) {
        const modal = document.getElementById('orderModal');
        const content = document.getElementById('orderContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        content.innerHTML = '<div class="flex items-center justify-center py-8"><i class="fas fa-circle-notch fa-spin text-primary text-2xl"></i></div>';
        
        fetch(`{{ route('affiliate.orders') }}/${orderId}/detail`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const order = data.order;
                    const shipping = data.shipping_details;
                    
                    let html = `
                        <div class="space-y-4">
                            <div class="bg-pink-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Order ID</p>
                                <p class="font-bold text-gray-800">${order.order_id}</p>
                                <p class="text-sm text-gray-500 mt-1">${new Date(order.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Items</p>
                                <div class="space-y-2">
                                    ${order.items.map(item => `
                                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                            <div>
                                                <p class="font-medium text-gray-800">${item.product?.name || 'Product'}</p>
                                                <p class="text-xs text-gray-500">${item.quantity}x @ Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                                            </div>
                                            <p class="font-bold text-primary">Rp ${Number(item.subtotal).toLocaleString('id-ID')}</p>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                            
                            ${shipping ? `
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Pengiriman</p>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm">
                                        <p><i class="fas fa-truck text-primary mr-2"></i> ${shipping.courier?.toUpperCase() || 'JNT'} - ${shipping.service || 'REG'}</p>
                                        <p class="text-gray-600 mt-1">${shipping.address || '-'}</p>
                                        <p class="text-primary font-medium mt-1">Ongkir: Rp ${Number(shipping.cost || 0).toLocaleString('id-ID')}</p>
                                    </div>
                                </div>
                            ` : ''}
                            
                            <div class="border-t pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-gray-800">Total</span>
                                    <span class="font-bold text-xl text-primary">Rp ${Number(order.amount).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                ${getStatusBadge(order.payment_status)}
                            </div>
                    `;
                    
                    if (order.payment_status === 'pending') {
                        html += `
                            <div class="pt-4">
                                <button onclick="retryPayment('${order.order_id}')" 
                                   class="w-full text-center bg-primary text-white py-3 rounded-xl font-bold hover:bg-red-800 transition-colors">
                                    <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                                </button>
                            </div>
                        `;
                    }
                    
                    html += '</div>';
                    content.innerHTML = html;
                }
            })
            .catch(err => {
                content.innerHTML = '<p class="text-red-500 text-center">Gagal memuat detail pesanan</p>';
            });
    }
    
    function closeModal() {
        const modal = document.getElementById('orderModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal on backdrop click
    document.getElementById('orderModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    function retryPayment(orderId) {
        const content = document.getElementById('orderContent');
        content.innerHTML = '<div class="flex flex-col items-center justify-center py-8"><i class="fas fa-circle-notch fa-spin text-primary text-2xl mb-4"></i><p class="text-gray-500">Menghubungkan ke payment gateway...</p></div>';
        
        fetch(`{{ route('affiliate.orders') }}/${orderId}/retry-payment`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.payment_link) {
                    window.location.href = data.payment_link;
                } else {
                    content.innerHTML = `<div class="text-center py-8"><i class="fas fa-exclamation-circle text-red-500 text-2xl mb-4"></i><p class="text-red-500">${data.message || 'Gagal membuat link pembayaran'}</p><button onclick="showOrderDetail('${orderId}')" class="mt-4 text-primary underline">Kembali</button></div>`;
                }
            })
            .catch(err => {
                // If response is a redirect (302), follow it
                if (err.redirect) {
                    window.location.href = err.redirect;
                } else {
                    content.innerHTML = `<div class="text-center py-8"><i class="fas fa-exclamation-circle text-red-500 text-2xl mb-4"></i><p class="text-red-500">Terjadi kesalahan. Silakan coba lagi.</p><button onclick="showOrderDetail('${orderId}')" class="mt-4 text-primary underline">Kembali</button></div>`;
                }
            });
    }
</script>
@endsection