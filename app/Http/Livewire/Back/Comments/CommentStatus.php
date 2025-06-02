<?php

namespace App\Http\Livewire\Back\Comments;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class CommentStatus extends Component
{
    public Model $model;

    public $field;

    public $approved;

    public function mount()
    {
        $this->approved = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        // Cek apakah approved saat ini adalah true
        if ($this->approved && ! $value) {
            // Jika approved true dan ingin mengubah ke false, batalkan perubahan
            return;
        }

        $this->model->setAttribute($this->field, $value)->save();
        flash()->addSuccess('Comment has been successfully approved');
        activity()
            ->causedBy(auth()->user())
            ->log('Approved comment ' . $this->model->username);
    }

    public function render()
    {
        return view('livewire.back.comments.comment-status');
    }
}
