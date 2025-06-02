<?php

namespace App\Http\Livewire\Back;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;
    public $decoration;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteClientAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteClient($id, $name)
    {
        $client = Client::find($id);
        $client->delete(); // This will now perform a soft delete

        flash()->addSuccess('Client has been moved to trash!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted client ' . $client->name);
    }

    public function render()
    {
        $clients = Client::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('image', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.client-list', [
            'clients' => $clients
        ]);
    }
}
