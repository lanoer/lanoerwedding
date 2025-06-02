<?php

namespace App\Http\Livewire\Back;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;

class TestimoniList extends Component
{
    use WithPagination;
    public $decoration;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteTestimoniAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteTestimoni($id, $name)
    {
        $testimoni = Testimonial::find($id);
        $testimoni->delete(); // This will now perform a soft delete

        flash()->addSuccess('Testimoni has been moved to trash!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted testimoni ' . $testimoni->name);
    }

    public function render()
    {
        $testimonials = Testimonial::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('testimoni', 'like', '%' . $this->search . '%')
                    ->orWhere('rating', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.testimoni-list', [
            'testimonials' => $testimonials
        ]);
    }
}
