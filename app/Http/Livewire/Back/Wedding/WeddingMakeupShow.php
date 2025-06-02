<?php

namespace App\Http\Livewire\Back\Wedding;

use App\Models\Weddings;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class WeddingMakeupShow extends Component
{
    public $weddingMakeups;
    protected $weddings;
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
        $wedding = Weddings::find($id);
        $wedding->delete(); // This will now perform a soft delete

        flash()->addSuccess('Wedding has been moved to trash!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted wedding ' . $wedding->name);
    }

    public function render()
    {
        $weddings = Weddings::where('wedding_makeups_id', $this->weddingMakeups->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.back.wedding.wedding-makeup-show', [
            'weddings' => $weddings
        ]);
    }
}
