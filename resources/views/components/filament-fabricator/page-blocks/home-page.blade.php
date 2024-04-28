@aware(['page'])
<div class="px-4 py-4 md:py-8">
    <div class="max-w-7xl mx-auto">
        <h1>{{ $page->title }}</h1>

        {!! $content !!}

        <x-curator-glider
        class="object-cover w-auto"
        :media="$image" 
        width="100"
        />

        
    </div>
</div>
