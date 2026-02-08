@extends('layouts.affiliate')
@section('title', 'Notifikasi')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Semua Notifikasi</h3>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">Riwayat notifikasi Anda</p>
                </div>
                @if($notifications->where('read_at', null)->count() > 0)
                <a href="{{ route('affiliate.notifications.mark-all-read') }}" 
                   class="text-xs text-[#7D2E35] hover:underline font-bold">
                    Tandai Semua Dibaca
                </a>
                @endif
            </div>
        </div>

        <div class="divide-y divide-gray-50">
            @forelse($notifications as $notification)
            <a href="{{ $notification->data['url'] ?? '#' }}" 
               class="block p-6 hover:bg-[#FFF9F9] transition-colors {{ is_null($notification->read_at) ? 'bg-[#FFF9F9]' : '' }}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#7D2E35] flex items-center justify-center text-white mr-4">
                        <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-1">
                            <p class="text-sm font-bold text-[#2C3E50]">
                                {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                            </p>
                            @if(is_null($notification->read_at))
                            <div class="flex-shrink-0 w-2 h-2 bg-[#7D2E35] rounded-full ml-2"></div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $notification->created_at->format('d M Y, H:i') }} 
                            <span class="mx-1">•</span>
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-12 text-center text-gray-400">
                <i class="far fa-bell text-6xl mb-4 opacity-20"></i>
                <p class="text-sm font-bold">Belum ada notifikasi</p>
                <p class="text-xs mt-2">Notifikasi Anda akan muncul di sini</p>
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="p-6 border-t border-gray-50">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
