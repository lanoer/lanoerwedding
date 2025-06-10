<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">About</h4>
            </div>
            <div class="card-body">
                <form action="" wire:submit.prevent="saveAbout()">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group mb-2">
                                <label for="">Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror" wire:model="title">
                                <span class="text-danger">
                                    @error('title')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Image</label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror" wire:model="image">
                                <span class="text-danger">
                                    @error('image')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group mb-2">
                                <div wire:loading wire:target="image" class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                @if ($image)
                                @if (is_string($image))
                                <img src="{{ asset('storage/back/images/about/' . $image) }}" class="img-thumbnail"
                                    style="width: 250px">
                                @else
                                <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="width: 250px">
                                @endif
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label for="">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror description"
                                    wire:model="description" id="description" wire:ignore></textarea>
                                <span class="text-danger">
                                    @error('description')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Meta Description</label>
                                <input type="text" name="meta_description" id="meta_description" class="form-control @error('meta_description')
                                                                is-invalid
                                                                @enderror" wire:model="meta_description">
                                <span class="text-danger">
                                    @error('meta_description')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Meta Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords')
                                                                is-invalid
                                                                @enderror" wire:model="meta_keywords">
                                <span class="text-danger">
                                    @error('meta_keywords')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Meta Tags</label>
                                <input type="text" name="meta_tags" id="meta_tags" class="form-control @error('meta_tags')
                                is-invalid
                                @enderror" wire:model="meta_tags">
                                <span class="text-danger">
                                    @error('meta_tags')
                                    {!! $message !!}
                                    @enderror
                                </span>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading wire:target="saveAbout" class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                <span wire:loading.remove wire:target="saveAbout">Save</span>
                                <span wire:loading wire:target="saveAbout">Saving...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

