<?php

namespace App\Http\Livewire\Back;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class SliderStatusCard extends Component
{
    public Model $model;

    public $field;

    public $isActive_card;

    public function mount()
    {
        $this->isActive_card = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
        flash()->addSuccess('Slider card has been successfuly updated');
        activity()
            ->causedBy(auth()->user())
            ->log('Updated Slider card status ' . $this->model->name);
    }
    public function render()
    {
        return view('livewire.back.slider-status-card');
    }
}
