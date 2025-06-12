<div>
    <!-- Display flash messages (Success/Error) -->
    <!-- Add New CateringPackage Button -->
    <div class="mb-3">
        <a href="{{ route('catering.main.create') }}" class="btn btn-success btn-sm">
            <i class="bx bx-plus"></i> Add New Catering Package
        </a>
    </div>

    <!-- Table -->
    <div class="row">
        @foreach ($caterings as $item)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <!-- Thumbnail image -->
                <img src="{{ asset('storage/back/images/event/eventmakeup/') }}" class="card-img-top" alt="Thumbnail"
                    style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    {{-- <p class="card-text">{!! $item->description !!}</p> --}}
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <!-- Display the count for premiumCaterings if greater than 0 -->
                        @if ($item->premium_caterings_count > 0)
                        <button class="btn btn-info btn-sm">
                            <span class="badge bg-primary">{{ $item->premium_caterings_count }}</span>
                        </button>
                        <a href="{{ route('catering.sub.viewPremium', $item->id) }}" class="btn btn-primary btn-sm mx-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                            <i class="bx bx-show"></i> View
                        </a>
                        @endif

                        <!-- Display the count for mediumCaterings if greater than 0 -->
                        @if ($item->medium_caterings_count > 0)
                        <button class="btn btn-info btn-sm">
                            <span class="badge bg-primary">{{ $item->medium_caterings_count }}</span>
                        </button>
                        <a href="{{ route('catering.sub.viewMedium', $item->id) }}" class="btn btn-primary btn-sm mx-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                            <i class="bx bx-show"></i> View
                        </a>
                        @endif

                        <!-- Edit Catering Package -->
                        <a href="{{ route('catering.main.edit', $item->id) }}" class="btn btn-warning btn-sm"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bx bx-edit"></i>
                        </a>

                        <!-- Delete Catering Package -->
                        <button wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="bx bx-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div> <!-- End of Card -->
        @endforeach
    </div> <!-- End of Row -->

</div>