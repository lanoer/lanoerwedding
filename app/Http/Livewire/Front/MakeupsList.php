<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\Event;
use App\Models\Weddings;
use Illuminate\Support\Collection;

class MakeupsList extends Component
{
    public $events;
    public $weddings;

    public $eventsEnd = false;
    public $weddingsEnd = false;

    protected $eventsPerPage = 3;
    protected $weddingsPerPage = 3;

    public function mount()
    {
        $this->weddings = Weddings::with('weddingMakeups')->take($this->weddingsPerPage)->get();
        $this->events = Event::with('eventMakeup')->take($this->eventsPerPage)->get();
    }

    public function loadMoreWeddings()
    {
        $next = Weddings::with('weddingMakeups')
            ->skip($this->weddings->count())
            ->take($this->weddingsPerPage)
            ->get();

        if ($next->isEmpty()) {
            $this->weddingsEnd = true;
        } else {
            $this->weddings = $this->weddings->merge($next);
        }
    }

    public function loadMoreEvents()
    {
        $next = Event::with('eventMakeup')
            ->skip($this->events->count())
            ->take($this->eventsPerPage)
            ->get();

        if ($next->isEmpty()) {
            $this->eventsEnd = true;
        } else {
            $this->events = $this->events->merge($next);
        }
    }

    public function render()
    {
        return view('livewire.front.makeups-list');
    }
}
