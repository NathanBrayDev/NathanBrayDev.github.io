@extends('components.filament-fabricator.layouts.default')

@section('content')
    
    <h1>{{ $page->title }}</h1>

    {{-- 'subtitle','summary', 'image', 'start_date', 'end_date', 'times', 'location','content'  --}}

    <p>{{ $page->start_date->format('d/m/Y') }} - {{ $page->end_date->format('d/m/Y') }}</p>

    <p>{{ $page->times }} - {{ $page->location }}</p>

    {!! $page->content !!}

    <x-curator-glider
    class="object-cover w-auto"
    :media="$page->image" 
    width="100"
    />

@endsection