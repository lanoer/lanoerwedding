<?php

namespace App\Http\Livewire\Back\Event;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class EventMakeupShow extends Component
{
    public $eventMakeups;
    protected $events;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteEventAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function deleteEvent($id, $name)
    {
        $event = Event::find($id);
        $event->delete(); // This will now perform a soft delete

        flash()->addSuccess('Event has been moved to trash!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted event ' . $event->name);
    }

    public function render()
    {
        $events = Event::where('event_makeups_id', $this->eventMakeups->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.back.event.event-makeup-show', [
            'events' => $events
        ]);
    }
}
