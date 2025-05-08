<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\EventMakeups;
use App\Models\WeddingMakeups;

class MakeupList extends Component
{
    public $eventMakeups;
    public $weddingMakeups;

    public function mount()
    {
        $this->eventMakeups = EventMakeups::withCount('events')->first();
        $this->weddingMakeups = WeddingMakeups::withCount('weddings')->first();
    }
    public function render()
    {
        return view('livewire.back.makeup-list');
    }
}
