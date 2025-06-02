<div>
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
    <form wire:submit.prevent="submitReply">

        <textarea wire:model.defer="replyContent" class="form-control" rows="2" placeholder="Write reply..."></textarea>
        <div class="mt-1">
            <button type="submit" class="btn btn-primary btn-sm">Send</button>
            <button type="button" class="btn btn-secondary btn-sm" wire:click="$emitUp('cancelReply')">Cancel</button>
        </div>
        @error('replyContent') <span class="text-danger">{{ $message }}</span> @enderror
    </form>
</div>