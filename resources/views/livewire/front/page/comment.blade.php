<div>
    <h4>Comments ({{ $comments->count() }})</h4>
    <ol class="comment-list">
        @foreach ($comments as $comment)
        @if (!$comment->is_admin_reply && $comment->parent_id == null)
        <li class="comment">
            <div class="comment-body">
                <div class="comment-author vcard">
                    @if (!$comment->is_admin_reply)
                    <img class="avatar photo user-avatar"
                        src="https://img.icons8.com/ios-filled/50/user-male-circle.png" alt="User">
                    @else
                    <img class="avatar photo admin-avatar" src="https://img.icons8.com/color/48/administrator-male.png"
                        alt="Admin">
                    @endif
                    <h3 class="name">{{ $comment->username }}</h3>
                </div>
                <div class="comment-meta">{{ $comment->created_at }}</div>
                <p>{{ $comment->comment }}</p>
                @php
                $adminReply = $comments->first(function($c) use ($comment) {
                return $c->parent_id == $comment->id && $c->is_admin_reply;
                });
                @endphp
                @if (auth()->check() && auth()->user()->hasRole('superadmin') && !$adminReply)
                <div class="reply">
                    <a href="#" wire:click.prevent="startReply({{ $comment->id }})" class="comment-reply-link">
                        <i class="ti-back-left"></i> Reply
                    </a>
                </div>
                @elseif(!$adminReply)
                <div class="reply">
                    <span class="text-muted">Waiting for admin reply</span>
                </div>
                @endif
            </div>
            {{-- Admin reply --}}
            @if ($adminReply)
            <ol class="children" style="margin-bottom: 2rem;">
                <li class="comment admin-reply">
                    <div class="comment-body" style="background: #f5f5f5; border-left: 3px solid #007bff;">
                        <div class="comment-author vcard">
                            <img class="avatar photo admin-avatar"
                                src="https://img.icons8.com/color/48/administrator-male.png" alt="Admin">
                            <h3 class="name">Admin</h3>
                            <span class="badge badge-primary ml-2">Admin</span>
                        </div>
                        <div class="comment-meta">{{ $adminReply->created_at}}</div>
                        <p>{{ $adminReply->comment }}</p>
                    </div>
                </li>
            </ol>
            @endif

            {{-- Form reply admin --}}
            @if ($replyingTo === $comment->id)
            <div class="mt-2 mb-4" style="margin-bottom: 3rem;">
                @livewire('front.page.comment-reply', ['commentId' => $comment->id], key('reply-'.$comment->id))
            </div>
            @endif
        </li>
        @endif
        @endforeach
    </ol>
    <style>
        .custom-hr {
            border: 0;
            height: 4px;
            width: 100%;
            background: linear-gradient(90deg, #a2783a 0%, #e0b973 50%, #986a25 100%);
            margin: 2.5rem 0 2rem 0;
            border-radius: 6px;
            box-shadow: 0 2px 12px 0 rgba(162, 120, 58, 0.15);
            opacity: 0.95;
            transition: box-shadow 0.3s, opacity 0.3s;
            animation: hr-glow 1.2s cubic-bezier(.4, 0, .2, 1);
        }

        @keyframes hr-glow {
            0% {
                opacity: 0;
                box-shadow: 0 0 0 0 rgba(162, 120, 58, 0.0);
            }

            100% {
                opacity: 0.95;
                box-shadow: 0 2px 12px 0 rgba(162, 120, 58, 0.15);
            }
        }
    </style>
    <hr class="custom-hr">
    <h3 class="pwe-about-heading">Leave a Comments</h3>
    <form method="post" class="row" wire:submit.prevent="submit" style="margin-top: 2rem;">

        @if (session('success'))
        <style>
            .alert {
                background-color: #007bff;
                color: #fff;
            }
        </style>
        <div class="alert">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" required wire:model="username">
                @error('username')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" wire:model="email">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Phone" wire:model="phone">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <textarea name="message" id="message" cols="30" rows="7" class="form-control" placeholder="Message"
                    wire:model="comment"></textarea>
                @error('comment')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <button type="submit" class="btn-contact" style="width: 120px;">
                    <span wire:loading.remove wire:target="submit">Submit</span>
                    <span wire:loading wire:target="submit">Loading...</span>
                </button>
            </div>
        </div>
    </form>


</div>