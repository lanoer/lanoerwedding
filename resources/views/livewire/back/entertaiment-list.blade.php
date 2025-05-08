<div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/back/images/entertainment/sound/' . $soundSystems->image) }}"
                    class="card-img-top" alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $soundSystems->name }}</h5>
                    <p class="card-text">{!! $soundSystems->description !!}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <button class="btn btn-info btn-sm">Total Sound System <span
                                class="badge bg-primary">{{ $soundSystems->sound_systems_count }}</span></button>
                        <a href="{{ route('entertainment.sound.show', $soundSystems->id) }}"
                            class="btn btn-primary btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Show Details"><i class="bx bx-show"></i></a>
                        <a href="{{ route('entertainment.sound.edit', $soundSystems->id) }}"
                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Edit Sound System"><i class="bx bx-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/back/images/entertainment/live/' . $lives->image) }}" class="card-img-top"
                    alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $lives->name }}</h5>
                    <p class="card-text">{!! $lives->description !!}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <button class="btn btn-info btn-sm">Total Live Music <span
                                class="badge bg-primary">{{ $lives->live_music_count }}</span></button>
                        <a href="{{ route('entertainment.live.show', $lives->id) }}" class="btn btn-primary btn-sm mx-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"><i
                                class="bx bx-show"></i></a>
                        <a href="{{ route('entertainment.live.edit', $lives->id) }}" class="btn btn-warning btn-sm"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Live Music"><i
                                class="bx bx-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/back/images/entertainment/ceremonial/' . $ceremonials->image) }}"
                    class="card-img-top" alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $ceremonials->name }}</h5>
                    <p class="card-text">{!! $ceremonials->description !!}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <button class="btn btn-info btn-sm">Total Ceremonial <span
                                class="badge bg-primary">{{ $ceremonials->ceremonial_events_count }}</span></button>
                        <a href="{{ route('entertainment.ceremonial.show', $ceremonials->id) }}"
                            class="btn btn-primary btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Show Details"><i class="bx bx-show"></i></a>
                        <a href="{{ route('entertainment.ceremonial.edit', $ceremonials->id) }}"
                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Edit Ceremonial"><i class="bx bx-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
