<?php

namespace App\Http\Livewire\Back;

use App\Models\CateringPackages;
use App\Models\Decorations;
use App\Models\EventMakeups;
use App\Models\LiveMusic;
use App\Models\SoundSystem;
use App\Models\User;
use App\Models\WeddingMakeups;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public $totalUsers, $totalWeddings, $totalEvent, $totalCatering, $totalDecorations, $totalMusic, $totalSoundSystem;

    public function mount()
    {
        $this->totalUsers = Cache::remember('totalUsers', 60, fn() => User::count());
        $this->totalWeddings = Cache::remember('totalWeddings', 60, fn() => WeddingMakeups::count());
        $this->totalEvent = Cache::remember('totalEvent', 60, fn() => EventMakeups::count());
        $this->totalCatering = Cache::remember('totalCatering', 60, fn() => CateringPackages::count());
        $this->totalDecorations = Cache::remember('totalDecorations', 60, fn() => Decorations::count());
        $this->totalMusic = Cache::remember('totalMusic', 60, fn() => LiveMusic::count());
        $this->totalSoundSystem = Cache::remember('totalSoundSystem', 60, fn() => SoundSystem::count());
    }

    public function render()
    {
        return view('livewire.back.home');
    }
}
