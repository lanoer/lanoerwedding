<?php

namespace App\Http\Livewire\Back\Entertainment;

use App\Models\CeremonialEvent;
use Livewire\Component;
use Livewire\WithPagination;

class CeremonialShow extends Component
{
    public $ceremonial;
    protected $ceremonials;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteCeremonialEventAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function deleteCeremonialEvent($id, $name)
    {
        $ceremonialEvent = CeremonialEvent::find($id);
        $ceremonialEvent->delete(); // This will now perform a soft delete

        flash()->addSuccess('Ceremonial Event has been moved to trash!');
    }

    public function render()
    {
        $ceremonialEvent = CeremonialEvent::where('ceremonial_id', $this->ceremonial->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.back.entertainment.ceremonial-show', [
            'ceremonialEvent' => $ceremonialEvent,
            'pagination' => $ceremonialEvent
        ]);
    }
}
