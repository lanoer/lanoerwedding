<?php

namespace App\Http\Livewire\Back;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class SliderList extends Component
{
    use WithPagination;
    public $decoration;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public $search = null;
    public $isLoading = false;

    protected $listeners = ['deleteSliderAction'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteSlider($id, $name)
    {
        $slider = Slider::find($id);
        $slider->delete(); // This will now perform a soft delete

        flash()->addSuccess('Slider has been moved to trash!');
    }

    public function render()
    {
        $sliders = Slider::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('desc_short', 'like', '%' . $this->search . '%')
                    ->orWhere('desc_long', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate($this->perPage);
        return view('livewire.back.slider-list', [
            'sliders' => $sliders
        ]);
    }
}
