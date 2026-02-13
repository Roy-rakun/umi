@extends('layouts.admin')
@section('title', 'Kelola Produk')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-[#E8E1D5] p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-[#2C3E50]">Daftar Produk</h3>
            <p class="text-sm text-gray-500">Kelola katalog produk, harga, dan tipe.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-[#2C3E50] text-white px-4 py-2 rounded hover:bg-[#1A252F] transition-colors">
            <i class="fas fa-plus mr-2"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F8F5F0] text-[#8B7355] text-sm uppercase tracking-wider">
                    <th class="p-4 border-b font-semibold">ID Produk</th>
                    <th class="p-4 border-b font-semibold">Media</th>
                    <th class="p-4 border-b font-semibold">Nama</th>
                    <th class="p-4 border-b font-semibold">Tipe</th>
                    <th class="p-4 border-b font-semibold">Harga</th>
                    <th class="p-4 border-b font-semibold">Komisi (L/D)</th>
                    <th class="p-4 border-b font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 border-b last:border-0 transition-colors">
                    <td class="p-4 font-mono text-xs">{{ $product->product_id }}</td>
                    <td class="p-4">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg border shadow-sm">
                        @elseif($product->icon)
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 border rounded-lg text-primary">
                                <iconify-icon icon="{{ $product->icon }}" class="text-xl"></iconify-icon>
                            </div>
                        @else
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 border rounded-lg text-gray-300">
                                <i class="fas fa-box"></i>
                            </div>
                        @endif
                    </td>
                    <td class="p-4 font-medium text-[#2C3E50]">{{ $product->name }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $product->type === 'physical' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ $product->type === 'physical' ? 'Fisik' : 'Digital' }}
                        </span>
                        @if($product->type === 'physical')
                            <div class="text-xs text-gray-400 mt-1">{{ $product->weight }}g</div>
                        @endif
                    </td>
                    <td class="p-4 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <div class="text-xs">
                            <span class="text-gray-500">Luar:</span> Rp {{ number_format($product->commission_outer, 0, ',', '.') }}<br>
                            <span class="text-gray-500">Dalam:</span> Rp {{ number_format($product->commission_inner, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <div class="flex items-center justify-end space-x-2">
                            <form action="{{ route('admin.products.reorder', [$product->product_id, 'up']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 transition-colors" title="Naikkan">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.products.reorder', [$product->product_id, 'down']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 transition-colors" title="Turunkan">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </form>
                            <div class="w-px h-4 bg-gray-200 mx-1"></div>
                            <a href="{{ route('admin.products.edit', $product->product_id) }}" class="text-[#8B7355] hover:text-[#6d5a43] font-medium transition-colors">Ubah</a>
                            <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400 italic">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection