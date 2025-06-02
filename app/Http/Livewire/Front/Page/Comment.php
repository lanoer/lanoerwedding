<?php

namespace App\Http\Livewire\Front\Page;

use Livewire\Component;
use App\Models\Comment as CommentModel;
use App\Models\Post;

class Comment extends Component
{
    public $post;

    public $username;

    public $email;

    public $phone;

    public $comment;

    public $replyingTo = null;

    protected $listeners = ['replyAdded' => '$refresh', 'cancelReply' => 'cancelReply'];

    public function startReply($commentId)
    {
        $this->replyingTo = $commentId;
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
    }

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function submit()
    {
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'comment' => 'required|string|max:1000',
        ], [
            'username.required' => 'Name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'comment.required' => 'Comment is required',
        ]);

        CommentModel::create([
            'post_id' => $this->post->id,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'comment' => $this->comment,
            'is_admin_reply' => false,
            'approved' => false,
        ]);

        $this->reset(['username', 'email', 'phone', 'comment']);
        session()->flash('success', 'Comment submitted successfully, Waiting for admin review');
    }

    public function render()
    {
        $comments = CommentModel::where('post_id', $this->post->id)
            ->where('approved', true)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.front.page.comment', compact('comments'));
    }
}
