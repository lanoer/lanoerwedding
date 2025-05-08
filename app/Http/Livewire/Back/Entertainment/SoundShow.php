<?php

namespace App\Http\Livewire\Back\Entertainment;

use App\Models\Sound;
use App\Models\SoundSystem;
use Livewire\Component;
use Livewire\WithPagination;

class SoundShow extends Component
{
    public $sound;
    protected $sounds;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteSoundAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function deleteSound($id, $name)
    {
        $sound = SoundSystem::find($id);
        $sound->delete(); // This will now perform a soft delete

        flash()->addSuccess('Sound has been moved to trash!');
    }

    public function render()
    {
        $sounds = SoundSystem::where('sounds_id', $this->sound->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.back.entertainment.sound-show', [
            'sounds' => $sounds
        ]);
    }
}
