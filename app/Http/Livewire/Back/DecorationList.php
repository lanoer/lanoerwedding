<?php

namespace App\Http\Livewire\Back;

use App\Models\Decorations;
use Livewire\Component;
use Livewire\WithPagination;

class DecorationList extends Component
{
    use WithPagination;
    public $decoration;
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

    public function deleteDecoration($id, $name)
    {
        $decoration = Decorations::find($id);
        $decoration->delete(); // This will now perform a soft delete

        flash()->addSuccess('Decoration has been moved to trash!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted decoration ' . $decoration->name);
    }

    public function render()
    {
        $decorations = Decorations::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.decoration-list', [
            'decorations' => $decorations
        ]);
    }
}
