@extends('layouts.admin')
@section('title', 'Payout Requests')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Payout Requests</h3>
            <p class="text-sm text-gray-500">Manage withdrawal requests from affiliates.</p>
        </div>
        <div class="flex space-x-2">
            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Payout ID</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Bank Account</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Request Date</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payouts as $payout)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-heading">
                            #{{ substr($payout->payout_id, -8) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-bold mr-2">
                                    {{ substr($payout->affiliate->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-heading">{{ $payout->affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $payout->affiliate->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600">
                            {{ $payout->affiliate->user->bank_account ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-heading">
                            Rp {{ number_format($payout->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($payout->status == 'completed')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Completed</span>
                            @elseif($payout->status == 'approved')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Approved</span>
                            @elseif($payout->status == 'rejected')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Rejected</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">{{ ucfirst($payout->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-gray-500">
                            {{ $payout->created_at->format('M d, Y') }}
                            <div class="text-[10px] text-gray-400">{{ $payout->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($payout->status == 'pending')
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.payouts.approve', $payout->payout_id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" onclick="return confirm('Approve payout sebesar Rp {{ number_format($payout->total_amount, 0, ',', '.') }}?')">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal('{{ $payout->payout_id }}', '{{ number_format($payout->total_amount, 0, ',', '.') }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                        <i class="fas fa-times mr-1"></i> Reject
                                    </button>
                                </div>
                            @elseif($payout->status == 'approved')
                                <form action="{{ route('admin.payouts.complete', $payout->payout_id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-primary hover:bg-red-800 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" onclick="return confirm('Tandai payout sebagai selesai/dibayar?')">
                                        <i class="fas fa-check-circle mr-1"></i> Mark Paid
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">
                                    <i class="fas fa-check"></i> {{ ucfirst($payout->status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">No payout requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $payouts->links() }}
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-heading">Reject Payout Request</h3>
                <p class="text-sm text-gray-500 mt-1">Payout ID: <span id="rejectPayoutId"></span></p>
                <p class="text-sm text-gray-500">Amount: Rp <span id="rejectPayoutAmount"></span></p>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="p-6">
                    <label class="block text-sm font-bold text-heading mb-2">Alasan Penolakan (Opsional)</label>
                    <textarea name="notes" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition-colors">
                        <i class="fas fa-times mr-1"></i> Reject Payout
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(payoutId, amount) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectPayoutId').textContent = payoutId;
            document.getElementById('rejectPayoutAmount').textContent = amount;
            document.getElementById('rejectForm').action = `/admin/payouts/${payoutId}/reject`;
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
@endsection

