@extends('layouts.admin')

@section('title', 'Landing Page Sections')
@section('subtitle', 'Manage different sections of your landing page')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($sections as $section)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $section->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><code>{{ $section->key }}</code></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('admin.landing.sections.reorder', [$section->id, 'up']) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-1 hover:bg-gray-100 rounded text-gray-400 hover:text-primary {{ $loop->first ? 'invisible' : '' }}">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.landing.sections.reorder', [$section->id, 'down']) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-1 hover:bg-gray-100 rounded text-gray-400 hover:text-primary {{ $loop->last ? 'invisible' : '' }}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </form>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $section->updated_at->diffForHumans() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.landing.sections.edit', $section->id) }}" class="text-primary hover:text-red-700">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
