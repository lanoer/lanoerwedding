<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\EventMakeups;
use App\Models\WeddingMakeups;
use App\Models\Event;
use App\Models\Weddings;

class MakeupsList extends Component
{
    public $eventMakeups;
    public $weddingMakeups;
    public $events;
    public $weddings;
    public $selectedEvent = '';
    public $selectedWedding = '';
    public $randomEvents;
    public $randomWeddings;

    public function mount()
    {
        $this->eventMakeups = EventMakeups::first();
        $this->weddingMakeups = WeddingMakeups::first();
        $this->events = Event::with('eventMakeup')->get();
        $this->weddings = Weddings::with('weddingMakeups')->get();
        $this->loadRandomItems();
    }

    public function loadRandomItems()
    {
        $this->randomEvents = Event::inRandomOrder()->take(3)->get();
        $this->randomWeddings = Weddings::inRandomOrder()->take(3)->get();
    }

    public function updatedSelectedEvent($value)
    {
        // Event dipilih: tidak perlu reset wedding
        // Bisa pilih dua-duanya
    }

    public function updatedSelectedWedding($value)
    {
        // Wedding dipilih: tidak perlu reset event
    }

    public function resetSelection()
    {
        $this->selectedEvent = '';
        $this->selectedWedding = '';
    }

    public function getSelectedEventDataProperty()
    {
        return $this->events->firstWhere('id', $this->selectedEvent);
    }

    public function getSelectedWeddingDataProperty()
    {
        return $this->weddings->firstWhere('id', $this->selectedWedding);
    }

    public function render()
    {
        return view('livewire.front.makeups-list', [
            'selectedEventData' => $this->selectedEventData,
            'selectedWeddingData' => $this->selectedWeddingData,
            'randomEvents' => $this->randomEvents,
            'randomWeddings' => $this->randomWeddings,
        ]);
    }
}
