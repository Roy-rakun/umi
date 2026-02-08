@extends('layouts.admin')
@section('title', 'Commissions Report')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Commissions Report</h3>
            <p class="text-sm text-gray-500">Detailed report of affiliate commissions and earnings.</p>
        </div>
        <div class="flex space-x-2">
            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-download mr-2"></i> Export
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Commission ID</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Order Ref</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($commissions as $commission)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-heading">
                            #{{ substr($commission->commission_id, -8) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-bold mr-2">
                                    {{ substr($commission->affiliate->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="text-xs font-medium text-heading">{{ $commission->affiliate->user->name ?? 'Unknown' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            #{{ $commission->order_id }}
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600">
                            {{ $commission->product->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right text-xs font-bold text-primary">
                            Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($commission->status == 'paid')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Paid</span>
                            @elseif($commission->status == 'approved')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Approved</span>
                            @elseif($commission->status == 'rejected')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Rejected</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">{{ ucfirst($commission->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-gray-500">
                            {{ $commission->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">No commissions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $commissions->links() }}
        </div>
    </div>
@endsection
