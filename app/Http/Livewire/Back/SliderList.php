<?php

namespace App\Http\Livewire\Back;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class SliderList extends Component
{
    use WithPagination;

    public $search = null;
    public $perPage = 5;
    public $isLoading = false;

    public $listeners = ['deleteSliderAction',  'updateSliderOrdering', 'refreshComponent' => '$refresh'];

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
        $slider->delete(); // Soft delete slider

        flash()->addSuccess('Slider telah dipindahkan ke tempat sampah!');
        activity()->causedBy(auth()->user())->log('Slider dihapus ' . $slider->title);
    }


    public function updateSliderOrdering($positions)
    {
        foreach ($positions as $p) {
            $id = $p[0];
            $newOrder = $p[1];

            if ($id !== null) {  // Pastikan ID valid
                Slider::where('id', $id)->update([
                    'ordering' => $newOrder,
                ]);
            }
        }

        flash()->addSuccess('Slider ordering berhasil diperbarui.');
        $this->emit('refreshComponent');
    }


    public function render()
    {
        $sliders = Slider::when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('desc_short', 'like', '%' . $this->search . '%')
                ->orWhere('desc_long', 'like', '%' . $this->search . '%');
        })
            ->orderBy('ordering', 'asc') // Urutkan berdasarkan kolom 'order'
            ->paginate($this->perPage);

        return view('livewire.back.slider-list', ['sliders' => $sliders]);
    }
}
