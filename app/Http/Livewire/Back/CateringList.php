<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\MediumCatering;
use App\Models\PremiumCatering;

class CateringList extends Component
{
    public $premiumCaterings;
    public $mediumCaterings;

    public function mount()
    {
        // Store the necessary attributes only as an array
        $this->premiumCaterings = PremiumCatering::first(['id', 'name', 'image', 'description']);
        $this->mediumCaterings = MediumCatering::first(['id', 'name', 'image', 'description']);
    }

    public function render()
    {
        return view('livewire.back.catering-list');
    }
}
