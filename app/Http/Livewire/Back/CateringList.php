<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CateringPackages;

class CateringList extends Component
{
    use WithPagination;
    public $catering;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteDecorationAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteCatering($id, $name)
    {
        $catering = CateringPackages::find($id);
        $catering->delete(); // This will now perform a soft delete

        flash()->addSuccess('Catering has been moved to trash!');
    }

    public function render()
    {
        $caterings = CateringPackages::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.catering-list', [
            'caterings' => $caterings
        ]);
    }
}
