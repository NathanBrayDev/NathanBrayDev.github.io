<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;

class ShowNews extends Component
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
        return view('livewire.show-news', [
            'news' => News::paginate($this->perPage),
            'page' => $this->page,
        ]);
    }

}