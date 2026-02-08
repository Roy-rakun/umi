@extends('layouts.admin')
@section('title', 'Fraud Detection Logs')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Fraud Detection Logs</h3>
            <p class="text-sm text-gray-500">Monitor suspicious activities and potential fraud attempts.</p>
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
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fraud Type</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Evidence</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Action Taken</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($fraudLogs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $log->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold mr-2">
                                    {{ substr($log->affiliate->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-heading">{{ $log->affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $log->affiliate->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-red-50 text-red-700 px-2 py-1 rounded-md text-xs font-medium border border-red-100">
                                {{ str_replace('_', ' ', ucfirst($log->fraud_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate">
                            {{ Str::limit(json_encode($log->evidence_data), 50) }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-gray-500">
                            {{ $log->order_id ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($log->action_taken)
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-[10px] font-medium">{{ $log->action_taken }}</span>
                            @else
                                <button class="text-red-600 hover:text-red-800 text-xs font-medium underline">
                                    Take Action
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-shield-alt text-4xl text-green-100 mb-2"></i>
                                <span>No fraud activities detected.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $fraudLogs->links() }}
        </div>
    </div>
@endsection
