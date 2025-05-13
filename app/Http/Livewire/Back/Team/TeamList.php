<?php

namespace App\Http\Livewire\Back\Team;

use App\Models\TeamLanoer;
use Livewire\Component;
use Livewire\WithPagination;

class TeamList extends Component
{
    use WithPagination;
    public $team;
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

    public function deleteTeam($id, $name)
    {
        $team = TeamLanoer::find($id);
        $team->delete(); // This will now perform a soft delete

        flash()->addSuccess('Team has been moved to trash!');
    }

    public function render()
    {
        $teams = TeamLanoer::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.team.team-list', [
            'teams' => $teams
        ]);
    }
}
