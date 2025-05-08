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
    // public function deleteEvent($id, $name)
    // {
    //     $this->dispatchBrowserEvent('deleteEvent', [
    //         'title' => 'Are you sure ?',
    //         'html' => 'You want to delete this event ' . $name . '?',
    //         'id' => $id,
    //     ]);
    // }

    // public function deleteEventAction($id)
    // {
    //     $event = Event::find($id);
    //     $path = 'back/images/event/eventmakeup/';
    //     $image = $event->image;
    //     if ($image != null && Storage::disk('public')->exists($path . $image)) {
    //         // delete resize image
    //         if (Storage::disk('public')->exists($path . 'thumbnails/resized_' . $image)) {
    //             Storage::disk('public')->delete($path . 'thumbnails/resized_' . $image);
    //         }
    //         // delete thumbnails
    //         if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
    //             Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
    //         }
    //         // delete post fetaured image
    //         Storage::disk('public')->delete($path . $image);
    //     }

    //     $delete_event = $event->delete();

    //     if ($delete_event) {
    //         flash()->addSuccess('Event has been successfuly deleted!');
    //     } else {
    //         flash()->addError('Something went wrong!');
    //     }
    // }

    public function deleteEvent($id, $name)
    {
        $event = Event::find($id);
        $event->delete(); // This will now perform a soft delete

        flash()->addSuccess('Event has been moved to trash!');
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
