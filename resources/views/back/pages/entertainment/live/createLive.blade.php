@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create Live Music')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">Create Live Music</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Create Live Music</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('entertainment.live.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <select name="lives_id" id="lives_id" class="form-control">
                        @foreach ($lives as $live)
                        <option value="{{ $live->id }}" selected>{{ $live->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" value="{{ old('image') }}">
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="image_holder mb-2" style="max-width: 250px">
                        <img src="{{ asset('storage/back/images/entertainment/live/' . old('image')) }}" alt=""
                            class="img-thumbnail" id="image-previewer">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="ckeditor form-control @error('description') is-invalid @enderror"
                            name="description" rows="6" placeholder="Content.."
                            id="description">{!! old('description') !!}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control @error('meta_description') is-invalid @enderror"
                            id="meta_description" name="meta_description" value="{{ old('meta_description') }}">
                        @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                            id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                        @error('meta_keywords')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_tags">Meta Tags</label>
                        <input type="text" class="form-control @error('meta_tags') is-invalid @enderror" id="meta_tags"
                            name="meta_tags" value="{{ old('meta_tags') }}">
                        @error('meta_tags')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="{{ route('entertainment.live.show', 1) }}" class="btn btn-warning mt-3"><i
                                class="bx bx-arrow-back"></i> Cancel</a>
                        <button type="submit" class="btn btn-primary mt-3"><i class="bx bx-save"></i> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheets')
<link href="{{ asset('back/assets/vendor/summernote/summernote-bs5.css') }}" rel="stylesheet">
@endpush


@push('scripts')
<script src="{{ asset('back/assets/vendor/summernote/summernote-bs5.js') }}"></script>
<script>
    $('input[name="meta_tags"]').amsifySuggestags({
    type: 'amsify'
    });
</script>

<script>
    $('#description').summernote({
            height: 300,

            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                },
                onMediaDelete: function(target) {
                    var imageUrl = target[0].src;
                    deleteImage(imageUrl);
                }
            }
        });

        function uploadImage(file) {
            var formData = new FormData();
            formData.append('image', file);

            $.ajax({
                url: 'entertainment/live/livemusic/upload-image', // Endpoint untuk upload gambar
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#description').summernote('insertImage', response
                        .location); // Sisipkan gambar setelah berhasil diupload
                }
            });
        }

        function deleteImage(imageUrl) {
            console.log("Mengirim URL gambar ke server untuk dihapus:", imageUrl); // Log URL gambar yang akan dihapus

            $.ajax({
                url: 'entertainment/live/livemusic/delete-image',
                type: 'POST',
                data: {
                    imageUrl: imageUrl,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Gambar berhasil dihapus');
                    } else {
                        console.log('Gambar gagal dihapus');
                    }
                }
            });
        }
</script>




<script>
    $(document).ready(function() {
            $('input[type="file"][name="image"]').ijaboViewer({
                preview: '#image-previewer',
                imageShape: 'rectangular',
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                onErrorShape: function(message, element) {
                    alert(message);
                },
                onInvalidType: function(message, element) {
                    alert(message);
                },
                onSuccess: function(message, element) {
                    // Success callback
                }
            });
        });
</script>
@endpush