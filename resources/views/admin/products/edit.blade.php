@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-[#E8E1D5] p-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h3 class="text-xl font-bold text-[#2C3E50]">Edit Product: {{ $product->name }}</h3>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <!-- Basic Info -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (IDR)</label>
                    <input type="number" name="price" value="{{ $product->price }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <input type="text" name="category" value="{{ $product->category }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
            </div>

            <!-- Type & Weight -->
            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Shipping Configuration</h4>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Type</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="digital" class="text-[#8B7355] focus:ring-[#8B7355]" {{ $product->type === 'digital' ? 'checked' : '' }} onchange="toggleWeight(false)">
                            <span class="ml-2">Digital (No Shipping)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="physical" class="text-[#8B7355] focus:ring-[#8B7355]" {{ $product->type === 'physical' ? 'checked' : '' }} onchange="toggleWeight(true)">
                            <span class="ml-2">Physical (Requires Shipping)</span>
                        </label>
                    </div>
                </div>

                <div id="weight-input" class="{{ $product->type === 'physical' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Weight (grams)</label>
                    <input type="number" name="weight" value="{{ $product->weight }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="e.g. 1000">
                    <p class="text-xs text-gray-500 mt-1">Required for J&T shipping calculation.</p>
                </div>
            </div>

            <!-- Commissions -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Inner (IDR)</label>
                    <input type="number" name="commission_inner" value="{{ $product->commission_inner }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Outer (IDR)</label>
                    <input type="number" name="commission_outer" value="{{ $product->commission_outer }}" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-[#8B7355] text-white px-6 py-2 rounded hover:bg-[#6d5a43] transition-colors font-bold">
                    Update Product
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleWeight(isPhysical) {
        const weightInput = document.getElementById('weight-input');
        if (isPhysical) {
            weightInput.classList.remove('hidden');
        } else {
            weightInput.classList.add('hidden');
        }
    }
</script>
@endsection
