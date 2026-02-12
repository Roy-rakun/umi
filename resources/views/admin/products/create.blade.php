@extends('layouts.admin')
@section('title', 'Add New Product')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-[#E8E1D5] p-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h3 class="text-xl font-bold text-[#2C3E50]">Add New Product</h3>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            <!-- Basic Info -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product ID (Unique)</label>
                <input type="text" name="product_id" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="e.g. PRD-001">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description / Detail</label>
                <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" rows="4"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <input type="file" name="product_image" class="w-full p-1 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355] text-sm file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fallback Icon</label>
                    <div x-data="iconPicker('')" class="relative">
                        <div class="flex items-center space-x-2">
                            <button type="button" @click="toggle" class="p-2 border border-gray-300 rounded bg-white hover:bg-gray-50 flex items-center justify-center min-w-[42px] h-[42px]">
                                <iconify-icon x-show="value" :icon="value" class="text-xl text-primary"></iconify-icon>
                                <i x-show="!value" class="fas fa-search text-gray-400"></i>
                            </button>
                            <input type="hidden" name="icon" x-model="value">
                            <span class="text-xs text-gray-500 italic">Digunakan jika foto tidak ada</span>
                        </div>
                        
                        <div x-show="open" @click.away="close" class="absolute z-50 mt-2 p-4 bg-white border border-gray-200 rounded-xl shadow-xl w-64">
                            <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari icon Lucide..." class="w-full p-2 mb-3 border border-gray-100 rounded-lg text-xs focus:ring-primary focus:border-primary">
                            <div class="grid grid-cols-5 gap-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="icon in filteredIcons()" :key="icon">
                                    <button type="button" @click="selectIcon(icon)" class="p-2 rounded-lg hover:bg-primary/10 transition-colors flex items-center justify-center border border-transparent hover:border-primary/20" :class="value === icon && 'bg-primary/5 border-primary/20'">
                                        <iconify-icon :icon="icon" class="text-lg text-gray-700"></iconify-icon>
                                    </button>
                                </template>
                            </div>
                            <div x-show="loading" class="text-center py-4">
                                <i class="fas fa-spinner fa-spin text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (IDR)</label>
                    <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <input type="text" name="category" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
            </div>

            <!-- Type & Weight -->
            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Shipping Configuration</h4>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Type</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="digital" class="text-[#8B7355] focus:ring-[#8B7355]" checked onchange="toggleWeight(false)">
                            <span class="ml-2">Digital (No Shipping)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="physical" class="text-[#8B7355] focus:ring-[#8B7355]" onchange="toggleWeight(true)">
                            <span class="ml-2">Physical (Requires Shipping)</span>
                        </label>
                    </div>
                </div>

                <div id="weight-input" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Weight (grams)</label>
                    <input type="number" name="weight" value="1000" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="e.g. 1000">
                    <p class="text-xs text-gray-500 mt-1">Required for J&T shipping calculation.</p>
                </div>
            </div>

            <!-- Commissions -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Inner (IDR)</label>
                    <input type="number" name="commission_inner" value="0" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Outer (IDR)</label>
                    <input type="number" name="commission_outer" value="0" class="w-full p-2 border border-gray-300 rounded focus:ring-[#8B7355] focus:border-[#8B7355]">
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-[#8B7355] text-white px-6 py-2 rounded hover:bg-[#6d5a43] transition-colors font-bold">
                    Create Product
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

    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
