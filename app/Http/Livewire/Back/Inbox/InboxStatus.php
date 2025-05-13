<?php

namespace App\Http\Livewire\Back\Inbox;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class InboxStatus extends Component
{
    public Model $model;

    public $field;

    public $isActive;

    public function mount()
    {
        $this->isActive = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        // Cek apakah isActive saat ini adalah true
        if ($this->isActive && ! $value) {
            // Jika isActive true dan ingin mengubah ke false, batalkan perubahan
            return;
        }

        $this->model->setAttribute($this->field, $value)->save();
        flash()->addSuccess('Inbox has been successfully read');
    }

    public function render()
    {
        return view('livewire.back.inbox.inbox-status');
    }
}
