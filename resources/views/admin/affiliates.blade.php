@extends('layouts.admin')
@section('title', 'Affiliates Management')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Affiliates List</h3>
            <p class="text-sm text-gray-500">Manage your partner network and track their performance.</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.affiliates.verify-all') }}" method="POST" onsubmit="return confirm('Verifikasi semua akun yang belum aktif?')">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors shadow-sm">
                    <i class="fas fa-check-double mr-2"></i> Verifikasi Semua
                </button>
            </form>
            <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-900 transition-colors shadow-sm">
                <i class="fas fa-plus mr-2"></i> Add New Affiliate
            </button>
        </div>
    </div>

    <!-- Affiliates Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Joined Date</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Earnings</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($affiliates as $affiliate)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm font-serif font-bold mr-3 border border-primary/20">
                                    {{ substr($affiliate->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-heading">{{ $affiliate->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $affiliate->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($affiliate->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                    {{ ucfirst($affiliate->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $affiliate->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-serif font-bold text-primary">
                                Rp {{ number_format($affiliate->total_commission, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(!$affiliate->user->hasVerifiedEmail())
                            <form action="{{ route('admin.affiliates.verify', $affiliate->affiliate_id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-amber-500 text-white px-2 py-1 rounded hover:bg-amber-600 transition-colors" title="Verifikasi Manual">
                                    Verifikasi
                                </button>
                            </form>
                            @else
                            <button class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                            No affiliates found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $affiliates->links() }}
        </div>
    </div>
@endsection
