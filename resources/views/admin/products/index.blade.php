@extends('layouts.admin')
@section('title', 'Manage Products')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-[#E8E1D5] p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-[#2C3E50]">Products List</h3>
            <p class="text-sm text-gray-500">Manage your product catalog, prices, and types.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-[#2C3E50] text-white px-4 py-2 rounded hover:bg-[#1A252F] transition-colors">
            <i class="fas fa-plus mr-2"></i> Add Product
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
                    <th class="p-4 border-b font-semibold">Product ID</th>
                    <th class="p-4 border-b font-semibold">Name</th>
                    <th class="p-4 border-b font-semibold">Type</th>
                    <th class="p-4 border-b font-semibold">Price</th>
                    <th class="p-4 border-b font-semibold">Commission (O/I)</th>
                    <th class="p-4 border-b font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 border-b last:border-0 transition-colors">
                    <td class="p-4 font-mono text-xs">{{ $product->product_id }}</td>
                    <td class="p-4 font-medium text-[#2C3E50]">{{ $product->name }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $product->type === 'physical' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ ucfirst($product->type) }}
                        </span>
                        @if($product->type === 'physical')
                            <div class="text-xs text-gray-400 mt-1">{{ $product->weight }}g</div>
                        @endif
                    </td>
                    <td class="p-4 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <div class="text-xs">
                            <span class="text-gray-500">Out:</span> Rp {{ number_format($product->commission_outer, 0, ',', '.') }}<br>
                            <span class="text-gray-500">In:</span> Rp {{ number_format($product->commission_inner, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product->product_id) }}" class="text-[#8B7355] hover:text-[#6d5a43] font-medium transition-colors">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400 italic">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
