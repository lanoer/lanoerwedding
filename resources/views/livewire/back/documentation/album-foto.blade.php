<div>
    <div class="row">
        <div class="app-container">
            <div class="row mt-3">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'albums' ? 'active' : '' }}" id="albums-tab"
                            data-bs-toggle="tab" data-bs-target="#albums" type="button" role="tab"
                            aria-controls="albums" aria-selected="{{ $activeTab === 'albums' ? 'true' : 'false' }}"
                            wire:click="setActiveTab('albums')">
                            Albums
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'videos' ? 'active' : '' }}" id="videos-tab"
                            data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab"
                            aria-controls="videos" aria-selected="{{ $activeTab === 'videos' ? 'true' : 'false' }}"
                            wire:click="setActiveTab('videos')">
                            Videos
                        </button>
                    </li>
                </ul>

                {{-- @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif --}}
                <!-- Tabs Content -->
                <div class="tab-content" id="myTabContent">
                    <!-- Albums Tab -->
                    <div class="tab-pane fade {{ $activeTab === 'albums' ? 'show active' : '' }}" id="albums"
                        role="tabpanel" aria-labelledby="albums-tab">
                        <div class="card card-box">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center position-relative my-1 me-5">
                                            Albums
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="Search album..."
                                                    wire:model.debounce.300ms="searchAlbum">

                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#album_modal">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                            rx="5" fill="currentColor"></rect>
                                                        <rect x="10.8891" y="17.8033" width="12" height="2"
                                                            rx="1" transform="rotate(-90 10.8891 17.8033)"
                                                            fill="currentColor"></rect>
                                                        <rect x="6.01041" y="10.9247" width="12" height="2"
                                                            rx="1" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                                Add Album
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Existing Album Table Content -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Album Name</th>
                                                <th>N. Of Foto</th>
                                                <th>Created At</th>
                                                <th class="w-1">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable_album">
                                            @forelse ($Albums as $a)
                                                <tr data-index="{{ $a->id }}"
                                                    data-ordering="{{ $a->ordering }}">
                                                    <td>{{ ($Albums->currentPage() - 1) * $Albums->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $a->album_name }}</td>
                                                    <td class="text-muted">
                                                        {{ $a->foto->count() }}
                                                    </td>
                                                    <td class="text-muted">
                                                        {{ $a->created_at->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="#"
                                                                wire:click.prevent='editAlbum({{ $a->id }})'
                                                                class="btn btn-sm btn-primary">Edit</a> &nbsp;
                                                            <a href="#"
                                                                wire:click.prevent='deleteAlbum({{ $a->id }})'
                                                                class="btn btn-sm btn-danger">Delete</a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"><span class="text-danger">Album Not
                                                            Found!</span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex mt-3">
                                    {{ $Albums->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Videos Tab -->
                    <div class="tab-pane fade {{ $activeTab === 'videos' ? 'show active' : '' }}" id="videos"
                        role="tabpanel" aria-labelledby="videos-tab">
                        <div class="card card-box">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center position-relative my-1 me-5">
                                            Videos
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <input type="text" class="form-control"
                                                    placeholder="Search video..."
                                                    wire:model.debounce.300ms="searchVideo">

                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#video_modal">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.3" x="2" y="2" width="20"
                                                            height="20" rx="5" fill="currentColor"></rect>
                                                        <rect x="10.8891" y="17.8033" width="12" height="2"
                                                            rx="1" transform="rotate(-90 10.8891 17.8033)"
                                                            fill="currentColor"></rect>
                                                        <rect x="6.01041" y="10.9247" width="12" height="2"
                                                            rx="1" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                                Add Video
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Video Name</th>
                                                <th>URL</th>
                                                <th>Created At</th>
                                                <th class="w-1">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($videos as $video)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $video->video_name }}</td>
                                                    <td class="text-muted">{{ $video->video_url }}</td>
                                                    <td class="text-muted">
                                                        {{ $video->created_at->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="#"
                                                                wire:click.prevent='editVideo({{ $video->id }})'
                                                                class="btn btn-sm btn-primary">Edit</a> &nbsp;
                                                            <button type="button"
                                                                wire:click="deleteVideo({{ $video->id }})"
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"><span class="text-danger">No Videos
                                                            Found!</span></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex mt-3">
                                    {{ $videos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="page-wrapper">
                    <div class="container-xl mb-3">
                        <!-- Page title -->
                        <div class="page-header d-print-none">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="page-title">
                                        Gallery
                                    </h2>
                                    {{-- <div class="text-muted mt-1">1-12 of 241 photos</div> --}}
                                </div>
                                <!-- Page title actions -->
                                <div class="col-auto ms-auto d-print-none">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <select wire:model='album' id="" class="form-control">
                                                    <option value="">-- ALL foto --</option>
                                                    @foreach ($AlbumList as $al)
                                                        <option value="{{ $al->id }}">{{ $al->album_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <a href="{{ route('documentation.add-foto') }}"
                                            class="btn btn-primary btn-sm" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="12" y1="5" x2="12" y2="19">
                                                </line>
                                                <line x1="5" y1="12" x2="19" y2="12">
                                                </line>
                                            </svg>
                                            Add Foto
                                        </a>
                                        <button id="deleteAllButton" class="btn btn-danger ms-2 btn-sm">
                                            Delete All
                                        </button>
                                        <button wire:click="selectAllFotos" class="btn btn-secondary ms-2 btn-sm">
                                            Select All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="container-xl">
                            <div class="row row-cards">
                                @forelse ($fotos as $foto)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="position-relative">
                                                <input type="checkbox" wire:model="selectedFotos"
                                                    value="{{ $foto->id }}"
                                                    class="position-absolute top-0 start-0 m-2">
                                                <a href="{{ asset('storage/back/images/album/foto/' . $foto->image) }}"
                                                    class="d-block" data-id="{{ $foto->id }}"
                                                    data-fancybox="gallery" data-caption="{{ $foto->title }}">
                                                    <img src="{{ asset('storage/back/images/album/foto/thumbnails/thumb_' . $foto->image) }}"
                                                        class="card-img-top">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-auto">
                                                        <a wire:click.prevent='deleteFoto({{ $foto->id }})'
                                                            href="" class="btn btn-sm btn-danger mt-1 mb-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                    <span class="text-danger">Not foto fond(s)</span>
                                @endforelse

                            </div>
                            <div class="d-flex">
                                {{ $fotos->links() }}
                            </div>
                        </div>
                    </div>
                    {{-- end --}}
                </div>


            </div>
            {{-- Modals --}}
            <div wire:ignore.self class="modal fade" id="album_modal" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">
                                {{ $updateAlbumMode ? 'Updated Album' : 'Add Album' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form class="modal-content" method="POST"
                            @if ($updateAlbumMode) wire:submit.prevent='updateAlbum()' @else wire:submit.prevent='addAlbum()' @endif>
                            <div class="modal-body">
                                @if ($updateAlbumMode)
                                    <input type="hidden" wire:model='selected_album_id'>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Album name</label>
                                    <input type="text" class="form-control" name="example-text-input"
                                        placeholder="Enter album name" wire:model='album_name'>
                                    <span class="text-danger">
                                        @error('album_name')
                                            {!! $message !!}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button type="submit"
                                    class="btn btn-primary">{{ $updateAlbumMode ? 'Update' : 'Save' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Video Modal --}}
            <div wire:ignore.self class="modal fade" id="video_modal" tabindex="-1" role="dialog"
                aria-labelledby="videoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel">
                                {{ $updateVideoMode ? 'Update Video' : 'Add Video' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form class="modal-content" method="POST"
                            @if ($updateVideoMode) wire:submit.prevent='updateVideo()' @else wire:submit.prevent='addVideo()' @endif>
                            <div class="modal-body">
                                @if ($updateVideoMode)
                                    <input type="hidden" wire:model='selected_video_id'>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Video Title</label>
                                    <input type="text" class="form-control" name="video_name"
                                        placeholder="Enter video title" wire:model='video_name'>
                                    <span class="text-danger">
                                        @error('video_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Video URL</label>
                                    <input type="text" class="form-control" name="video_url"
                                        placeholder="Enter video URL (YouTube/Vimeo)" wire:model='video_url'>
                                    <span class="text-danger">
                                        @error('video_url')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                    class="btn btn-primary">{{ $updateVideoMode ? 'Update' : 'Save' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
        @push('stylesheets')
            <link rel="stylesheet" href="/back/assets/vendor/fancybox/dist/jquery.fancybox.min.css" />
        @endpush
        @push('scripts')
            <script src="/back/assets/vendor/fancybox/dist/jquery.fancybox.min.js"></script>

            <script>
                // Fancybox Config
                $('[data-fancybox="gallery"]').fancybox({
                    buttons: [
                        "slideShow",
                        "thumbs",
                        "zoom",
                        "fullScreen",
                        "share",
                        "close"
                    ],
                    loop: false,
                    protect: true
                });
            </script>
        @endpush
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('deleteAllButton').addEventListener('click', function() {
                        // Ambil nilai album dari Livewire
                        var album = @this.get('album');

                        if (confirm('Are you sure? You won\'t be able to revert this!')) {
                            // console.log('Confirmed'); // Tambahkan log untuk debugging
                            if (album) {
                                Livewire.emit('deleteSelectedFotos', album);
                            } else {
                                Livewire.emit('deleteSelectedFotos');
                            }
                        }
                    });
                });
            </script>
        @endpush
        @push('scripts')
            <script>
                window.addEventListener('hideVideoModal', event => {
                    $('#video_modal').modal('hide');
                });
                window.addEventListener('showVideoModal', event => {
                    $('#video_modal').modal('show');
                });
                $('#video_modal').on('hide.bs.modal', function(e) {
                    Livewire.emit('resetVideoInputs');
                });
                document.addEventListener('livewire:load', function() {
                    Livewire.hook('message.processed', (message, component) => {
                        // Setelah setiap request Livewire selesai
                        if (component.get('activeTab') === 'videos') {
                            $('#videos-tab').tab('show');
                        } else {
                            $('#albums-tab').tab('show');
                        }
                    });
                });
            </script>
        @endpush
        @push('scripts')
            <script>
                window.addEventListener('confirmDelete', event => {
                    if (confirm('Are you sure you want to delete ' + event.detail.name + '?')) {
                        @this.call('deleteVideoAction', event.detail.id);
                    }
                });
            </script>
        @endpush



    </div>
</div>
