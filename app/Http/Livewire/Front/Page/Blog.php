<?php

namespace App\Http\Livewire\Front\Page;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::where('isActive', 1)
            ->with('author', 'subcategory')
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        return view('livewire.front.page.blog', compact('posts'));
    }
}
