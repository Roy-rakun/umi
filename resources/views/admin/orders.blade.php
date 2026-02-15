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

    <!-- Bulk Action Bar -->
    <div id="bulkActionBar" class="hidden bg-primary/10 border border-primary/20 rounded-xl p-4 mb-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-sm font-bold text-primary">
                <span id="selectedCount">0</span> pesanan dipilih
            </span>
            <button onclick="selectAll()" class="text-xs text-primary underline hover:no-underline">Pilih Semua</button>
            <button onclick="deselectAll()" class="text-xs text-gray-500 underline hover:no-underline">Batal Pilih</button>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="bulkCancel()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-600 transition-colors" style="background-color:#f59e0b">
                <i class="fas fa-ban mr-2"></i> Batalkan Terpilih
            </button>
            <button onclick="bulkDelete()" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600 transition-colors">
                <i class="fas fa-trash mr-2"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    <form id="bulkActionForm" method="POST" action="">
        @csrf
        <input type="hidden" name="action" id="bulkActionInput" value="">
        <input type="hidden" name="order_ids" id="bulkOrderIdsInput" value="">
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-4 text-center">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                        </th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ref Affiliate</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors" data-order-id="{{ $order->order_id }}" data-payment-status="{{ $order->payment_status }}">
                        <td class="px-4 py-4 text-center" onclick="event.stopPropagation()">
                            <input type="checkbox" class="order-checkbox w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary" value="{{ $order->order_id }}" onchange="updateBulkBar()">
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-heading cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            #{{ $order->order_id }}
                        </td>
                        <td class="px-6 py-4 cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            <div class="text-xs font-bold text-heading">{{ $order->buyer_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->buyer_email }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            {{ $order->product->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            @if($order->affiliate)
                                <div class="text-xs font-medium text-primary">{{ $order->affiliate->user->name ?? 'Tidak Dikenal' }}</div>
                                <div class="text-[10px] text-gray-400">Ref: {{ $order->affiliate_ref }}</div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-heading cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            Rp {{ number_format($order->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            @if($order->payment_status == 'paid')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Dibayar</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Tertunda</span>
                            @elseif($order->payment_status == 'cancelled')
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Dibatalkan</span>
                            @elseif($order->payment_status == 'failed')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Gagal</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">{{ $order->payment_status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-gray-500 cursor-pointer" onclick="window.location='{{ route('admin.orders.detail', $order->order_id) }}'">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4" onclick="event.stopPropagation()">
                            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center; justify-content: center;">
                                @if($order->payment_status != 'cancelled' && $order->payment_status != 'failed')
                                    <form action="{{ route('admin.orders.cancel', $order->order_id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        @csrf
                                        <button type="submit" style="background-color: #f59e0b; color: white; font-size: 11px; padding: 5px 10px; border-radius: 6px; border: none; cursor: pointer;">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus pesanan ini? Data yang dihapus tidak dapat dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #ef4444; color: white; font-size: 11px; padding: 5px 10px; border-radius: 6px; border: none; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $orders->links() }}
        </div>
    </div>

    <script>
        const selectedOrders = new Set();
        
        function updateBulkBar() {
            const checkboxes = document.querySelectorAll('.order-checkbox:checked');
            selectedOrders.clear();
            checkboxes.forEach(cb => selectedOrders.add(cb.value));
            
            const bulkBar = document.getElementById('bulkActionBar');
            const countEl = document.getElementById('selectedCount');
            
            if (selectedOrders.size > 0) {
                bulkBar.classList.remove('hidden');
                countEl.textContent = selectedOrders.size;
            } else {
                bulkBar.classList.add('hidden');
            }
            
            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('.order-checkbox');
            const selectAllCb = document.getElementById('selectAllCheckbox');
            if (checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0) {
                selectAllCb.checked = true;
                selectAllCb.indeterminate = false;
            } else if (checkboxes.length > 0) {
                selectAllCb.checked = false;
                selectAllCb.indeterminate = true;
            } else {
                selectAllCb.checked = false;
                selectAllCb.indeterminate = false;
            }
        }
        
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
            updateBulkBar();
        }
        
        function selectAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = true);
            updateBulkBar();
        }
        
        function deselectAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = false);
            document.getElementById('selectAllCheckbox').checked = false;
            updateBulkBar();
        }
        
        function getSelectedOrderIds() {
            return Array.from(selectedOrders);
        }
        
        function bulkCancel() {
            const ids = getSelectedOrderIds();
            if (ids.length === 0) {
                alert('Pilih minimal satu pesanan.');
                return;
            }
            
            // Filter out already cancelled/failed orders
            const cancellableIds = ids.filter(id => {
                const row = document.querySelector(`tr[data-order-id="${id}"]`);
                const status = row?.dataset.paymentStatus;
                return status !== 'cancelled' && status !== 'failed';
            });
            
            if (cancellableIds.length === 0) {
                alert('Tidak ada pesanan yang dapat dibatalkan.\nPesanan dengan status "Dibatalkan" atau "Gagal" tidak dapat dibatalkan lagi.');
                return;
            }
            
            if (!confirm(`Yakin ingin membatalkan ${cancellableIds.length} pesanan terpilih?`)) {
                return;
            }
            
            document.getElementById('bulkActionInput').value = 'cancel';
            document.getElementById('bulkOrderIdsInput').value = JSON.stringify(cancellableIds);
            document.getElementById('bulkActionForm').action = '{{ route('admin.orders.bulk-action') }}';
            document.getElementById('bulkActionForm').submit();
        }
        
        function bulkDelete() {
            const ids = getSelectedOrderIds();
            if (ids.length === 0) {
                alert('Pilih minimal satu pesanan.');
                return;
            }
            
            if (!confirm(`Yakin ingin menghapus ${ids.length} pesanan terpilih?\nData yang dihapus tidak dapat dikembalikan.`)) {
                return;
            }
            
            document.getElementById('bulkActionInput').value = 'delete';
            document.getElementById('bulkOrderIdsInput').value = JSON.stringify(ids);
            document.getElementById('bulkActionForm').action = '{{ route('admin.orders.bulk-action') }}';
            document.getElementById('bulkActionForm').submit();
        }
    </script>
@endsection