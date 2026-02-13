@extends('layouts.affiliate')
@section('title', 'Analisis Performa')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-[#E8E1D5] p-6 mb-6">
    <h3 class="text-xl font-bold text-[#2C3E50] mb-4">Ringkasan Performa</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
            <p class="text-sm text-blue-600 font-medium">Click-Through Rate</p>
            <p class="text-2xl font-bold text-[#2C3E50]">2.4%</p>
        </div>
        <div class="p-4 bg-green-50 rounded-lg border border-green-100">
            <p class="text-sm text-green-600 font-medium">Conversion Rate</p>
            <p class="text-2xl font-bold text-[#2C3E50]">1.8%</p>
        </div>
        <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
            <p class="text-sm text-purple-600 font-medium">EPC (Pendapatan Per Klik)</p>
            <p class="text-2xl font-bold text-[#2C3E50]">Rp 2,500</p>
        </div>
    </div>
    <div class="border-2 border-dashed border-gray-200 rounded-lg h-64 flex items-center justify-center text-gray-400">
        Grafik Detail (Klik vs Penjualan) akan ada di sini
    </div>
</div>
@endsection