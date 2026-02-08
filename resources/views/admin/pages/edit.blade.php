@extends('layouts.admin')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Edit Page: {{ $page->title }}
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">
                    Page Title
                </label>
                <input class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input" 
                    type="text" 
                    name="title" 
                    value="{{ old('title', $page->title) }}" 
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">
                    Slug (Cannot be changed)
                </label>
                <input class="block w-full mt-1 text-sm text-gray-500 bg-gray-100 border-gray-300 rounded-md shadow-sm form-input" 
                    type="text" 
                    value="{{ $page->slug }}" 
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">
                    Content (HTML Supported)
                </label>
                <div class="text-xs text-gray-500 mb-2">
                    You can use HTML tags like &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;b&gt; for formatting.
                </div>
                <textarea class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-textarea" 
                    rows="20" 
                    name="content" 
                    required>{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-gray-200 border border-transparent rounded-lg active:bg-gray-300 hover:bg-gray-300 focus:outline-none focus:shadow-outline-gray mr-2">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Update Page
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
