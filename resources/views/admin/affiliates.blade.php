@extends('layouts.admin')
@section('title', 'Manajemen Affiliate')
@section('content')
<div x-data="{ 
    showAddModal: false,
    selectedIds: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedIds = Array.from(document.querySelectorAll('.affiliate-checkbox')).map(el => el.value);
        } else {
            this.selectedIds = [];
        }
    },
    updateSelectAll() {
        const checkboxes = document.querySelectorAll('.affiliate-checkbox');
        this.selectAll = checkboxes.length > 0 && this.selectedIds.length === checkboxes.length;
    }
}">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-serif font-bold text-heading">Daftar Affiliate</h3>
            <p class="text-sm text-gray-500">Kelola jaringan mitra Anda dan pantau performa mereka.</p>
        </div>
        <div class="flex gap-2">
            <button @click="showAddModal = true" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-900 transition-colors shadow-sm flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Affiliate
            </button>
        </div>
    </div>

    <!-- Bulk Action Bar -->
    <div x-show="selectedIds.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white border border-primary/20 rounded-xl p-4 mb-6 flex items-center justify-between shadow-sm shadow-primary/5">
        <div class="flex items-center gap-3">
            <span class="text-sm font-bold text-primary bg-primary/10 px-3 py-1 rounded-full" x-text="selectedIds.length + ' dipilih'"></span>
            <div class="h-4 w-px bg-gray-200 mx-2"></div>
            <p class="text-xs text-gray-500 font-medium italic">Pilih aksi untuk affiliate yang ditandai:</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.affiliates.bulk-action') }}" method="POST" @submit="return confirm('Lanjutkan aksi massal untuk ' + selectedIds.length + ' affiliate?')">
                @csrf
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <div class="flex gap-2">
                    <select name="action" class="text-xs border-gray-200 rounded-lg focus:ring-primary focus:border-primary py-2 px-3 bg-gray-50 font-medium outline-none">
                        <option value="">-- Pilih Aksi --</option>
                        <option value="verify">Verifikasi Akun</option>
                        <option value="set_inner">Pindahkan ke Grup Inner</option>
                        <option value="set_outer">Pindahkan ke Grup Outer</option>
                        <option value="delete">Hapus Permanen</option>
                    </select>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-900 transition-colors shadow-sm">
                        Terapkan
                    </button>
                    <button type="button" @click="selectedIds = []; selectAll = false" class="text-gray-400 hover:text-gray-600 px-2 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Affiliate -->
    <div x-show="showAddModal" 
         class="fixed inset-0 z-[1000] flex items-center justify-center p-4"
         x-cloak
         role="dialog"
         aria-modal="true"
         style="display: none;">
        
        <!-- Backdrop (Dark Layer) -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
             @click="showAddModal = false"
             x-show="showAddModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all z-[1001]"
             x-show="showAddModal"
             @click.stop
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-serif font-bold text-heading">Tambah Affiliate Baru</h3>
                    <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 transition-colors p-2 -mr-2">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.affiliates.store') }}" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="budi@example.com">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">No. WhatsApp</label>
                            <input type="text" name="phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="08123456789">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password Login</label>
                            <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Grup Affiliate</label>
                            <select name="level" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                                <option value="outer">OUTER (Komisi Standar)</option>
                                <option value="inner">INNER (Komisi Khusus)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="showAddModal = false" class="flex-1 px-6 py-3.5 bg-gray-50 text-gray-600 rounded-xl font-bold hover:bg-gray-100 transition-all font-medium">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3.5 bg-primary text-white rounded-xl font-bold hover:bg-red-900 transition-all shadow-lg shadow-primary/20 font-medium">
                            Daftarkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Affiliate -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left w-10">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="rounded border-gray-300 text-primary focus:ring-primary">
                        </th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Affiliate</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Group</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Penghasilan</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($affiliates as $affiliate)
                    <tr class="hover:bg-gray-50/50 transition-colors group" :class="selectedIds.includes('{{ $affiliate->affiliate_id }}') ? 'bg-primary/5' : ''">
                        <td class="px-6 py-4">
                            <input type="checkbox" 
                                   value="{{ $affiliate->affiliate_id }}" 
                                   x-model="selectedIds" 
                                   @change="updateSelectAll()"
                                   class="affiliate-checkbox rounded border-gray-300 text-primary focus:ring-primary">
                        </td>
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
                            <form action="{{ route('admin.affiliates.update-group', $affiliate->affiliate_id) }}" method="POST" x-data @change="$el.submit()">
                                @csrf
                                <div class="inline-flex rounded-xl border border-gray-200 p-1 bg-gray-100/50">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="level" value="inner" {{ $affiliate->level === 'inner' ? 'checked' : '' }} class="hidden">
                                        <span class="px-4 py-1.5 text-[10px] font-black rounded-lg flex items-center transition-all uppercase tracking-tighter {{ $affiliate->level === 'inner' ? 'bg-primary text-white shadow-md' : 'text-gray-400 hover:text-gray-600' }}">INNER</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="level" value="outer" {{ $affiliate->level === 'outer' ? 'checked' : '' }} class="hidden">
                                        <span class="px-4 py-1.5 text-[10px] font-black rounded-lg flex items-center transition-all uppercase tracking-tighter {{ $affiliate->level === 'outer' ? 'bg-primary text-white shadow-md' : 'text-gray-400 hover:text-gray-600' }}">OUTER</span>
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            @if(!$affiliate->user->email_verified_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                    Belum Verifikasi
                                </span>
                            @elseif($affiliate->status == 'active')
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
                            <div class="flex justify-center gap-2">
                                @if(!$affiliate->user->hasVerifiedEmail())
                                    <form action="{{ route('admin.affiliates.verify', $affiliate->affiliate_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-amber-600 hover:text-amber-700 p-2 rounded-lg bg-amber-50 transition-colors" title="Verifikasi">
                                            <i class="fas fa-user-check text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.affiliates.destroy', $affiliate->affiliate_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus affiliate ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 p-2 rounded-lg bg-red-50 transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
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
</div>
@endsection