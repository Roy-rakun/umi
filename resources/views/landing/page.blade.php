@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="bg-[#FFF9F9] py-12 md:py-20 text-center border-b border-pink-100">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl md:text-5xl font-serif text-heading mb-4">{{ $page->title }}</h1>
        <div class="w-24 h-1 bg-[#7D2E35] mx-auto rounded-full"></div>
    </div>
</div>

<!-- Page Content -->
<div class="py-16 px-4 bg-white">
    <div class="max-w-4xl mx-auto prose prose-pink prose-lg text-gray-600 font-light">
        {!! $page->content !!}
    </div>
</div>
@endsection
