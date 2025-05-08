<div>
    <form method="POST" wire:submit.prevent='UpdateBlogSocialMedia()'>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Facebook</label>
                    <input type="text" class="form-control" placeholder="Facebook page url" wire:model='facebook'>
                    <span class="text-danger">
                        @error('facebook')
                            {!! $message !!}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Instagram</label>
                    <input type="text" class="form-control" placeholder="Instagram url" wire:model='instagram'>
                    <span class="text-danger">
                        @error('instagram')
                            {!! $message !!}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Youtube</label>
                    <input type="text" class="form-control" placeholder="Youtube url" wire:model='youtube'>
                    <span class="text-danger">
                        @error('youtube')
                            {!! $message !!}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Twitter</label>
                    <input type="text" class="form-control" placeholder="Twitter url" wire:model='twitter'>
                    <span class="text-danger">
                        @error('twitter')
                            {!! $message !!}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Web</label>
                    <input type="text" class="form-control" placeholder="web url" wire:model='web'>
                    <span class="text-danger">
                        @error('web')
                            {!! $message !!}
                        @enderror
                    </span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading wire:target="UpdateBlogSocialMedia" class="spinner-border spinner-border-sm"
                role="status" aria-hidden="true"></span>
            <span wire:loading.remove wire:target="UpdateBlogSocialMedia">Save</span>
            <span wire:loading wire:target="UpdateBlogSocialMedia">Saving...</span>
        </button>
    </form>
</div>
