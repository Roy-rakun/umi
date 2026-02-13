@extends('layouts.admin')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Buat Halaman Baru
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.pages.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">
                    Judul Halaman
                </label>
                <input class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input" 
                    type="text" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required>
            </div>

            <div class="mb-4">
                <label class="flex items-center text-sm font-semibold text-gray-700">
                    <input type="checkbox" name="is_academy" value="1" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 mr-2">
                    <span>Hanya untuk Academy (Affiliator)</span>
                </label>
                <p class="text-[10px] text-gray-400 mt-1 italic pl-6">Jika dicentang, halaman ini hanya akan muncul di dashboard Academy para affiliator.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">
                    Konten (Mendukung HTML)
                </label>
                <div class="text-xs text-gray-500 mb-2">
                    Anda dapat menggunakan tag HTML seperti <h2>, <p>, <ul>, <b> untuk pemformatan.
                </div>
                <textarea class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-textarea wysiwyg" 
                    rows="20" 
                    name="content" 
                    required>{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-gray-200 border border-transparent rounded-lg active:bg-gray-300 hover:bg-gray-300 focus:outline-none focus:shadow-outline-gray mr-2">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Simpan Halaman
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('.wysiwyg'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection