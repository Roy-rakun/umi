@extends('layouts.affiliate')
@section('title', 'Help Center')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-surface rounded-3xl p-8 shadow-sm border border-gray-50 mb-10">
        <div class="flex items-start mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-5">
                <i class="fas fa-question-circle text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Pusat Bantuan & Panduan</h3>
                <p class="text-xs text-gray-400 font-medium tracking-wide">Semua yang Anda butuhkan untuk mulai menghasilkan uang</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($pages as $page)
            <a href="{{ url('page/' . $page->slug) }}" target="_blank" class="flex items-center p-6 bg-white border border-gray-100 rounded-2xl hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-gray-50 text-[#7D2E35] rounded-xl flex items-center justify-center mr-4 group-hover:bg-[#FFF0F0] transition-colors">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-[#2C3E50] group-hover:text-[#7D2E35] transition-colors">{{ $page->title }}</h4>
                    <p class="text-xs text-gray-400">Klik untuk membaca panduan lengkap</p>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </a>
            @empty
            <div class="col-span-2 py-12 text-center">
                <p class="text-gray-400">Belum ada panduan yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
