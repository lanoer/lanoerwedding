<?php

namespace App\Http\Livewire\Back\Comments;

use Livewire\Component;
use App\Models\Comment;
use Livewire\WithPagination;
use Spatie\Activitylog\Facades\Activity;

class AllComments extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $listeners = [
        'resetModalForm',
        'deleteKomentarAction',
    ];

    public function deleteKomentar($id)
    {
        $comment = Comment::find($id);
        $this->dispatchBrowserEvent('deleteKomentar', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete comment from <b>' . $comment->username . '</b>',
            'id' => $id,
        ]);
    }

    public function deleteKomentarAction($id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->delete();
        flash()->addSuccess('Komentar has been successfuly deleted.');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted comment ' . $comment->username);
    }

    public function render()
    {
        $comments = Comment::whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.back.comments.all-comments', [
            'comments' => $comments,
        ]);
    }
}
