<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\Sound;
use App\Models\Live;
use App\Models\Ceremonial;

class EntertaimentList extends Component
{
    public $soundSystems;
    public $lives;
    public $ceremonials;
    public function mount()
    {
        $this->soundSystems = Sound::withCount('soundSystems')->first();
        $this->lives = Live::withCount('liveMusic')->first();
        $this->ceremonials = Ceremonial::withCount('ceremonialEvents')->first();
    }
    public function render()
    {
        return view('livewire.back.entertaiment-list');
    }
}
