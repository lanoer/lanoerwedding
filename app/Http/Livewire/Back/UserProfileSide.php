<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;

class UserProfileSide extends Component
{
    protected $listeners = [
        'updateUserProfileSide' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.back.user-profile-side');
    }
}
