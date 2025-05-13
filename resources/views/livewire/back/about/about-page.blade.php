<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">About</h4>
            </div>
            <div class="card-body">
                <form action="" wire:submit.prevent="saveAbout()">
                    <div class="row">
                        <div class="col-6">
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
                                <label for="">Description Short</label>
                                <textarea name="desc_singkat" id="desc_singkat" class="form-control @error('desc_singkat') is-invalid @enderror"
                                    wire:model="desc_singkat"></textarea>
                                <span class="text-danger">
                                    @error('desc_singkat')
                                        {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2" wire:ignore>
                                <label for="">Description Long</label>
                                <textarea name="desc_lengkap" id="desc_lengkap" class="form-control @error('desc_lengkap') is-invalid @enderror"
                                    wire:model="desc_lengkap"></textarea>
                                <span class="text-danger">
                                    @error('desc_lengkap')
                                        {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2" wire:ignore>
                                <label for="">Our Mission</label>
                                <textarea name="ourmission" id="ourmission" class="form-control @error('ourmission') is-invalid @enderror"
                                    wire:model="ourmission"></textarea>
                                <span class="text-danger">
                                    @error('ourmission')
                                        {!! $message !!}
                                    @enderror
                                </span>
                            </div>


                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label for="">Image<small><strong>466x311</strong></small></label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror" wire:model="image">
                                <span class="text-danger">
                                    @error('image')
                                        {!! $message !!}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group mb-2">
                                <div wire:loading wire:target="image" class="spinner-border text-primary"
                                    role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                @if ($image)
                                    @if (is_string($image))
                                        <img src="{{ asset('storage/back/images/about/' . $image) }}"
                                            class="img-thumbnail" style="width: 250px">
                                    @else
                                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail"
                                            style="width: 250px">
                                    @endif
                                @endif
                            </div>
                            <div class="form-group mb-2" wire:ignore>
                                <label for="">Our Vision</label>
                                <textarea name="ourvision" id="ourvision" class="form-control @error('ourvision') is-invalid @enderror"
                                    wire:model="ourvision"></textarea>
                                <span class="text-danger">
                                    @error('ourvision')
                                        {!! $message !!}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-2" wire:ignore>
                                <label for="">Our Commitment</label>
                                <textarea name="ourcommitment" id="ourcommitment" class="form-control @error('ourcommitment') is-invalid @enderror"
                                    wire:model="ourcommitment"></textarea>
                                <span class="text-danger">
                                    @error('ourcommitment')
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
@push('scripts')
    <script src="{{ asset('back/assets/vendor/ckeditor/build/ckeditor.js') }}"></script>
@endpush
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            function initializeCKEditor() {
                if (document.querySelector('#desc_lengkap') && !document.querySelector('#desc_lengkap')
                    .ckeditorInstance) {
                    ClassicEditor
                        .create(document.querySelector('#desc_lengkap'), {
                            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                                'blockQuote'
                            ],
                            heading: {
                                options: [{
                                        model: 'paragraph',
                                        title: 'Paragraph',
                                        class: 'ck-heading_paragraph'
                                    },
                                    {
                                        model: 'heading1',
                                        view: 'h1',
                                        title: 'Heading 1',
                                        class: 'ck-heading_heading1'
                                    },
                                    {
                                        model: 'heading2',
                                        view: 'h2',
                                        title: 'Heading 2',
                                        class: 'ck-heading_heading2'
                                    }
                                ]
                            }
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                @this.set('desc_lengkap', editor.getData());
                            });
                            document.querySelector('#desc_lengkap').ckeditorInstance = editor;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }



            ClassicEditor
                .create(document.querySelector('#ourmission'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            }
                        ]
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('ourmission', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
            ClassicEditor
                .create(document.querySelector('#ourvision'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            }
                        ]
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('ourvision', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
            ClassicEditor
                .create(document.querySelector('#ourcommitment'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            }
                        ]
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('ourcommitment', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
            initializeCKEditor();

            Livewire.hook('message.processed', (message, component) => {
                initializeCKEditor();
            });
        });
    </script>
@endpush
