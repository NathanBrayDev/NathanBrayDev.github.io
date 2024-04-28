<div>
    @foreach($events as $event)

            {{ $event->title }}

            {!! $event->start_date->format('d/m/Y') !!}

            <x-curator-glider
            class="object-cover"
            :media="$event->image"
            width="100px"
            />

            <a href="{{ url('events/'. $event->slug) }}"></a>

            <hr>

        @endforeach

        {{-- {{ $events->links() }} --}}

        @if($events->hasMorePages())

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
