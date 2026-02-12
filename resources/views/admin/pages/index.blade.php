@extends('layouts.admin')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl font-semibold text-gray-700">
            Page Management
        </h2>
        <a href="{{ route('admin.pages.create') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            + Add New Page
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Slug (URL)</th>
                        <th class="px-4 py-3">Last Updated</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @foreach($pages as $page)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <span class="font-semibold">{{ $page->title }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $page->slug }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $page->updated_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-4 text-sm">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    <span class="ml-2">Edit</span>
                                </a>
                                <button onclick="copyToClipboard('{{ url('/' . $page->slug) }}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg focus:outline-none focus:shadow-outline-gray" title="Copy Link">
                                    <i class="fas fa-copy w-5 h-5 flex items-center justify-center"></i>
                                    <span class="ml-2">Copy Link</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    if (!navigator.clipboard) {
        // Fallback for older browsers
        const el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('Link copied to clipboard!');
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection

