@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('subtitle', 'Monitor your affiliate system performance')

@section('content')
<!-- Welcome Banner -->
<div class="bg-[#7D2E35] rounded-2xl p-8 text-white mb-10 shadow-lg relative overflow-hidden group">
    <!-- Decorative Circle -->
    <div class="absolute -right-10 -top-20 w-80 h-80 rounded-full border-8 border-white/5 opacity-50 group-hover:scale-105 transition-transform duration-700"></div>
    <div class="absolute -right-10 -top-20 w-80 h-80 rounded-full border-[16px] border-white/5 opacity-30 group-hover:scale-110 transition-transform duration-700 delay-75"></div>
    
    <div class="relative z-10 max-w-2xl">
        <h1 class="font-serif text-3xl font-bold mb-3 tracking-wide">Welcome back, Administrator</h1>
        <p class="text-pink-100 font-light text-sm md:text-base leading-relaxed">
            Your ethical affiliate system is running smoothly. Here's your overview for today.
        </p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Sales -->
    <div class="bg-surface rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-primary">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <span class="text-[10px] font-bold {{ $revGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-0.5 rounded-full">
                {{ $revGrowth >= 0 ? '+' : '' }}{{ number_format($revGrowth, 1) }}%
            </span>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Total Sales</p>
            <h3 class="font-serif text-2xl font-bold text-heading">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Total Commissions -->
    <div class="bg-surface rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-primary">
                <i class="fas fa-wallet"></i>
            </div>
            <span class="text-[10px] font-bold {{ $commGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-0.5 rounded-full">
                {{ $commGrowth >= 0 ? '+' : '' }}{{ number_format($commGrowth, 1) }}%
            </span>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Approved Commissions</p>
            <h3 class="font-serif text-2xl font-bold text-heading">Rp {{ number_format($approvedCommissions, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Active Affiliates -->
    <div class="bg-surface rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-primary">
                <i class="fas fa-users"></i>
            </div>
            <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+{{ $newAffiliatesCount }}</span>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Active Affiliates</p>
            <h3 class="font-serif text-2xl font-bold text-heading">{{ number_format($activeAffiliates) }}</h3>
        </div>
    </div>

    <!-- Pending Payouts -->
    <div class="bg-surface rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 border border-gray-50">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                <i class="fas fa-clock"></i>
            </div>
            <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full">Req. Payout</span>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Pending Payouts</p>
            <h3 class="font-serif text-2xl font-bold text-heading">Rp {{ number_format($pendingPayouts, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Top Affiliates Table -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-serif text-lg font-bold text-heading">Top Affiliates</h3>
            <a href="{{ route('admin.affiliates') }}" class="text-xs font-medium text-primary bg-pink-50 px-3 py-1 rounded-full hover:bg-primary hover:text-white transition-colors">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Earnings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($topAffiliates as $affiliate)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold font-serif mr-3">
                                    {{ substr($affiliate->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-heading">{{ $affiliate->user->name }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $affiliate->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-primary font-medium capitalize">{{ $affiliate->level }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs font-bold text-heading">
                                Rp {{ number_format($affiliate->total_commission, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-xs text-gray-400 italic">No data available yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-serif text-lg font-bold text-heading">Recent Orders</h3>
            <a href="{{ route('admin.orders') }}" class="text-xs font-medium text-primary bg-pink-50 px-3 py-1 rounded-full hover:bg-primary hover:text-white transition-colors">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Commission</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 max-w-[150px]">
                            <div class="text-xs font-bold text-heading truncate">{{ $order->product->name ?? 'Unknown Product' }}</div>
                            <div class="text-[10px] text-gray-400">#{{ $order->order_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-600">{{ $order->affiliate_ref ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs font-bold text-primary">
                                Rp {{ number_format($order->commission->commission_amount ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-xs text-gray-400 italic">No orders yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



