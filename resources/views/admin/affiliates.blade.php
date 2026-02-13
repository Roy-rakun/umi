@extends('layouts.admin')
@section('title', 'Manajemen Affiliate')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Daftar Affiliate</h3>
            <p class="text-sm text-gray-500">Kelola jaringan mitra Anda dan pantau performa mereka.</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.affiliates.verify-all') }}" method="POST" onsubmit="return confirm('Verifikasi semua akun yang belum aktif?')">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors shadow-sm">
                    <i class="fas fa-check-double mr-2"></i> Verifikasi Semua
                </button>
            </form>
            <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-900 transition-colors shadow-sm">
                <i class="fas fa-plus mr-2"></i> Tambah Affiliate
            </button>
        </div>
    </div>

    <!-- Tabel Affiliate -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Penghasilan</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
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
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                    {{ $affiliate->status == 'inactive' ? 'Tidak Aktif' : 'Ditangguhkan' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $affiliate->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-serif font-bold text-primary">
                                Rp {{ number_format($affiliate->total_commission, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                                @if(!$affiliate->user->hasVerifiedEmail())
                                    <form action="{{ route('admin.affiliates.verify', $affiliate->affiliate_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" style="background-color: #f59e0b; color: white; font-size: 12px; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            Verifikasi
                                        </button>
                                    </form>
                                @endif

                                @if($affiliate->status == 'suspended')
                                    <form action="{{ route('admin.affiliates.unsuspend', $affiliate->affiliate_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" style="background-color: #22c55e; color: white; font-size: 12px; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            Aktifkan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.affiliates.suspend', $affiliate->affiliate_id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menangguhkan affiliate ini?')">
                                        @csrf
                                        <button type="submit" style="background-color: #eab308; color: white; font-size: 12px; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            Suspend
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.affiliates.destroy', $affiliate->affiliate_id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus affiliate ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #ef4444; color: white; font-size: 12px; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                            Belum ada affiliate.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginasi -->
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $affiliates->links() }}
        </div>
    </div>
@endsection