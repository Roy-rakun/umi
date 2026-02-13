@extends('layouts.admin')
@section('title', 'Laporan Analitik')
@section('content')
    <div class="mb-8">
        <h3 class="text-xl font-serif font-bold text-heading">Laporan & Analitik</h3>
        <p class="text-sm text-gray-500">Ringkasan performa bisnis Anda.</p>
    </div>

    <!-- Kartu Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pendapatan</h4>
                <div class="p-2 bg-green-100 rounded-lg text-green-600">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="text-3xl font-serif font-bold text-heading">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <p class="text-xs text-green-500 mt-2 flex items-center">
                <i class="fas fa-arrow-up mr-1"></i> Penghasilan Keseluruhan
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Komisi</h4>
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div class="text-3xl font-serif font-bold text-heading">
                Rp {{ number_format($totalCommission, 0, ',', '.') }}
            </div>
            <p class="text-xs text-blue-500 mt-2 flex items-center">
                <i class="fas fa-check-circle mr-1"></i> Dicairkan & Disetujui
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Grafik Pendapatan Bulanan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-bold text-heading mb-6">Pendapatan Bulanan (6 Bulan Terakhir)</h4>
            
            <div class="h-64 flex items-end justify-between space-x-2">
                @php $maxRevenue = $monthlyRevenue->max('total') ?: 1; @endphp
                @foreach($monthlyRevenue as $data)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-primary/80 rounded-t-sm hover:bg-primary transition-all relative group-hover:shadow-lg" 
                             style="height: {{ ($data->total / $maxRevenue) * 100 }}%">
                             <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                Rp {{ number_format($data->total, 0, ',', '.') }}
                             </div>
                        </div>
                        <div class="text-[10px] text-gray-500 mt-2 font-medium">{{ \Carbon\Carbon::parse($data->month)->format('M Y') }}</div>
                    </div>
                @endforeach
                
                @if($monthlyRevenue->isEmpty())
                    <div class="w-full h-full flex items-center justify-center text-gray-400 italic">
                        Belum ada data pendapatan.
                    </div>
                @endif
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-bold text-heading mb-6">Produk Terlaris</h4>
            
            <div class="space-y-4">
                @forelse($topProducts as $item)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-100">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 mr-3">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-heading">{{ $item->product->name ?? 'Tidak Dikenal' }}</div>
                                <div class="text-xs text-gray-400">{{ $item->total_sold }} Terjual</div>
                            </div>
                        </div>
                        <div class="text-sm font-bold text-primary">
                            #{{ $loop->iteration }}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 italic py-4">Belum ada data penjualan.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection