<div>
    <div class="services-section services pt-0 pb-90">

        {{-- Dropdown Makeup --}}
        <div class="d-flex flex-column align-items-center">
            {{-- Event Select --}}
            <div class="mb-3">
                <select class="form-select styled-select" wire:model="selectedEvent">
                    <option value="">Pilih {{ $eventMakeups->name }}</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Wedding Select --}}
            <div class="mb-3">
                <select class="form-select styled-select" wire:model="selectedWedding">
                    <option value="">Pilih {{ $weddingMakeups->name }}</option>
                    @foreach ($weddings as $wedding)
                        <option value="{{ $wedding->id }}">{{ $wedding->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="mb-4">
                <button wire:click="resetSelection" class="btn btn-outline-warning btn-sm">
                    <i class="ti-reload"></i>
                </button>
            </div>
        </div>

        {{-- Display Content --}}
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">

                {{-- Event --}}
                @if ($selectedEventData)
                    <div class="col-md-4" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('storage/back/images/event/eventmakeup/' . $selectedEventData->image) }}"
                                    alt="{{ $selectedEventData->name }}" class="img-fluid rounded">
                            </div>
                            <div class="con">
                                <span class="category">
                                    <a
                                        href="{{ route('makeup.event', ['eventMakeupSlug' => $selectedEventData->eventMakeup->slug]) }}">{{ $selectedEventData->eventMakeup->name ?? '' }}</a>
                                </span>
                                <h5><a
                                        href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $selectedEventData->eventMakeup->slug, 'slug' => $selectedEventData->slug]) }}">{{ $selectedEventData->name }}</a>
                                </h5>
                                <a
                                    href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $selectedEventData->eventMakeup->slug, 'slug' => $selectedEventData->slug]) }}"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Wedding --}}
                @if ($selectedWeddingData)
                    <div class="col-md-4" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $selectedWeddingData->image) }}"
                                    alt="{{ $selectedWeddingData->name }}" class="img-fluid rounded">
                            </div>
                            <div class="con">
                                <span class="category">
                                    <a
                                        href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $selectedWeddingData->weddingMakeups->slug]) }}">{{ $selectedWeddingData->weddingMakeups->name ?? '' }}</a>
                                </span>
                                <h5><a
                                        href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $selectedWeddingData->weddingMakeups->slug]) }}">{{ $selectedWeddingData->name }}</a>
                                </h5>
                                <a
                                    href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $selectedWeddingData->weddingMakeups->slug, 'slug' => $selectedWeddingData->slug]) }}"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Jika tidak memilih apapun --}}
                @if (!$selectedEventData && !$selectedWeddingData)
                    {{-- Random Event --}}
                    @foreach ($randomEvents as $event)
                        <div class="col-md-4" data-animate-effect="fadeInLeft">
                            <div class="item mb-30">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('storage/back/images/event/eventmakeup/' . $event->image) }}"
                                        alt="{{ $event->name }}" class="img-fluid rounded">
                                </div>
                                <div class="con">
                                    <span class="category">
                                        <a
                                            href="{{ route('makeup.event', ['eventMakeupSlug' => $event->eventMakeup->slug]) }}">{{ $event->eventMakeup->name ?? '' }}</a>
                                    </span>
                                    <h5><a
                                            href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $event->eventMakeup->slug, 'slug' => $event->slug]) }}">{{ $event->name }}</a>
                                    </h5>
                                    <a
                                        href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $event->eventMakeup->slug, 'slug' => $event->slug]) }}"><i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Random Wedding --}}
                    @foreach ($randomWeddings as $wedding)
                        <div class="col-md-4" data-animate-effect="fadeInLeft">
                            <div class="item mb-30">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $wedding->image) }}"
                                        alt="{{ $wedding->name }}" class="img-fluid rounded">
                                </div>
                                <div class="con">
                                    <span class="category">
                                        <a
                                            href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug]) }}">{{ $wedding->weddingMakeups->name ?? '' }}</a>
                                    </span>
                                    <h5><a
                                            href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug]) }}">{{ $wedding->name }}</a>
                                    </h5>
                                    <a
                                        href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug, 'slug' => $wedding->slug]) }}"><i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        .styled-select {
            border: 1px solid #ad8852;
            height: 45px;
            font-size: 16px;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
        }

        .styled-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(162, 120, 58, 0.3);
            border-color: #a2783a;
        }

        select option:hover {
            background-color: #a2783a !important;
            color: #fff !important;
        }

        select option:checked {
            background-color: #a2783a;
            color: #fff;
        }
    </style>
@endpush
