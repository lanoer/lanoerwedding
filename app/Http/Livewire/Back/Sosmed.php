<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
use Livewire\Component;

class Sosmed extends Component
{
    public $fb;

    public $ig;

    public $tw;

    public $tik;

    public function mount()
    {
        $this->fb = User::find(auth()->user()->id)->fb;
        $this->ig = User::find(auth()->user()->id)->ig;
        $this->tw = User::find(auth()->user()->id)->tw;
        $this->tik = User::find(auth()->user()->id)->tik;
    }

    public function updateSosmed()
    {
        User::whereId(auth()->user()->id)->update([
            'fb' => $this->fb,
            'ig' => $this->ig,
            'tw' => $this->tw,
            'tik' => $this->tik,
        ]);

        // Log aktivitas


        $this->showToastr('Sosial media successfuly updated', 'success');
    }

    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.back.sosmed');
    }
}
