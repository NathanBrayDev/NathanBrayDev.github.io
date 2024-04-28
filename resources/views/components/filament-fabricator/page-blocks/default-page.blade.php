@aware(['page'])

<div class="px-4 py-4 md:py-8">
    <div class="max-w-7xl mx-auto">
        <h1>{{ $page->title }}</h1>
        

        {!! $page->content !!}

    </div>
</div>

@if(View::exists('livewire.show-' . $page->slug))
    @livewire( "show-" . $page->slug )
@endif