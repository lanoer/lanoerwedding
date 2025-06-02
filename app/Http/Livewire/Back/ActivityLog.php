<?php

namespace App\Http\Livewire\Back;

use Spatie\Activitylog\Models\Activity;
use Livewire\Component;

class ActivityLog extends Component
{
    public $activities;

    public function mount()
    {
        $this->activities = Activity::with('causer')->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.back.activity-log');
    }
}
