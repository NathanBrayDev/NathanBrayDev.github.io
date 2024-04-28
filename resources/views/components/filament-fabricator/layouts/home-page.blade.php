@extends('components.filament-fabricator.layouts.master')


@props(['page'])

@section('content')
    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />
@endsection

