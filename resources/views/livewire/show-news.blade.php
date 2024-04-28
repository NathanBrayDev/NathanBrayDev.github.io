<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    @foreach($news as $news_item)

            {{ $news_item->title }}

            {!! $news_item->summary !!}

            <x-curator-glider
            class="object-cover"
            :media="$news_item->image"
            width="100px"
            />

            <a href="{{ url('news/'. $news_item->slug) }}"></a>

            <hr>

        @endforeach


        {{-- {{ $news->links() }} --}}

        @if($news->hasMorePages())

            <button wire:click.prevent="loadMore">Load more</button>

            <script type="text/javascript">
                    window.onscroll = function(ev) {
                      if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                          @this.call('loadMore');
                      }
                    };
            </script>
        @endif
</div>
