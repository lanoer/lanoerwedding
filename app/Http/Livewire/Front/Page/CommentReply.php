<?php

namespace App\Http\Livewire\Front\Page;

use Livewire\Component;
use App\Models\Comment;

class CommentReply extends Component
{
    public $commentId;
    public $replyContent = '';

    protected $rules = [
        'replyContent' => 'required|string|max:1000',
    ];

    public function submitReply()
    {
        $this->validate();

        // Pastikan hanya admin
        if (!auth()->check() || !auth()->user()->hasRole('superadmin')) {
            session()->flash('error', 'Only admin can reply.');
            return;
        }

        $parent = Comment::findOrFail($this->commentId);

        Comment::create([
            'post_id' => $parent->post_id,
            'parent_id' => $parent->id,
            'username' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => '',
            'comment' => $this->replyContent,
            'is_admin_reply' => 1,
            'approved' => 1,
        ]);

        $this->emitUp('replyAdded');
        $this->replyContent = '';
        $this->dispatchBrowserEvent('close-reply-form-' . $this->commentId);
        session()->flash('success', 'Reply submitted successfully');
    }

    public function render()
    {
        return view('livewire.front.page.comment-reply');
    }
}
