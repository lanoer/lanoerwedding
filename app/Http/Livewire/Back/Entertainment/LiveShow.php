<?php

namespace App\Http\Livewire\Back\Entertainment;

use App\Models\Live;
use App\Models\LiveMusic;
use Livewire\Component;
use Livewire\WithPagination;

class LiveShow extends Component
{
    public $live;
    protected $lives;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteLiveMusicAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function deleteLiveMusic($id, $name)
    {
        $liveMusic = LiveMusic::find($id);
        $liveMusic->delete(); // This will now perform a soft delete

        flash()->addSuccess('Live Music has been moved to trash!');
    }

    public function render()
    {
        $liveMusic = LiveMusic::where('lives_id', $this->live->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        return view('livewire.back.entertainment.live-show', [
            'liveMusic' => $liveMusic,
            'pagination' => $liveMusic
        ]);
    }
}
