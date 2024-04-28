<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class ShowEvents extends Component
{

    public $page;

    // use WithPagination;
    public $perPage = 20;


    public function loadMore()
    {
        $this->perPage += 1;
    }

    public function render()
    {
        return view('livewire.show-events', [
            'events' => Event::paginate($this->perPage),
            'page' => $this->page,
        ]);
    }
}
