@extends('components.filament-fabricator.layouts.default')

@section('content')
    
    <h1>{{ $page->title }}</h1>

    {!! $page->content !!}

    <x-curator-glider
    class="object-cover w-auto"
    :media="$page->image" 
    width="100"
    />

@endsection