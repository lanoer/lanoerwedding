<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public $totalUsers;

    public function mount()
    {


        $this->totalUsers = Cache::remember('totalUsers', 60, function () {
            return User::count();
        });
    }

    public function render()
    {


        return view('livewire.back.home');
    }
}
