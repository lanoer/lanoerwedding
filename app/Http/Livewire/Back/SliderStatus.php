<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class SliderStatus extends Component
{
    public Model $model;

    public $field;

    public $isActive_slider;

    public function mount()
    {
        $this->isActive_slider = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
        flash()->addSuccess('Slider has been successfuly updated');
        activity()
            ->causedBy(auth()->user())
            ->log('Updated Slider status ' . $this->model->name);
    }
    public function render()
    {
        return view('livewire.back.slider-status');
    }
}
