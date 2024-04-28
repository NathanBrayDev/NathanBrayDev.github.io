@extends('components.filament-fabricator.layouts.master')
    
@section('content')        

    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />
    
@endsection