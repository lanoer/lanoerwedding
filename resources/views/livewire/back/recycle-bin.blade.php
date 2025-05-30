<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Recycle Bin</h4>
            <div class="mt-2 d-flex gap-3">
                <div class="position-relative" style="width: 200px;">
                    <select wire:model.live="type" class="form-select">
                        @foreach (['all', 'events', 'weddings', 'decorations', 'soundSystems', 'liveMusics', 'ceremonialEvents', 'fotos', 'caterings', 'teamLanoers', 'sliders', 'testimonials', 'clients'] as $typeOption)
                            <option value="{{ $typeOption }}">{{ ucfirst($typeOption) }}</option>
                        @endforeach
                    </select>
                    <div wire:loading wire:target="type" class="position-absolute top-50 end-0 translate-middle-y me-2">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <div class="position-relative">
                        <input type="date" wire:model.live="startDate" class="form-control" style="width: 150px;"
                            placeholder="Start Date" max="{{ $endDate ?? date('Y-m-d') }}">
                    </div>
                    <span>to</span>
                    <div class="position-relative">
                        <input type="date" wire:model.live="endDate" class="form-control" style="width: 150px;"
                            placeholder="End Date" min="{{ $startDate ?? '' }}" max="{{ date('Y-m-d') }}">
                    </div>
                    @if ($startDate || $endDate)
                        <button wire:click="resetDates" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    @endif
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="input-group position-relative">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search...">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <div wire:loading wire:target="search"
                        class="position-absolute top-50 end-0 translate-middle-y me-2">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = [
                                'events' => [
                                    'collection' => $events,
                                    'type' => 'Event',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restore',
                                    'deleteMethod' => 'forceDelete',
                                ],
                                'weddings' => [
                                    'collection' => $weddings,
                                    'type' => 'Wedding',
                                    'badge' => 'bg-warning',
                                    'restoreMethod' => 'restoreWedding',
                                    'deleteMethod' => 'forceDeleteWedding',
                                ],
                                'decorations' => [
                                    'collection' => $decorations,
                                    'type' => 'Decoration',
                                    'badge' => 'bg-primary',
                                    'restoreMethod' => 'restoreDecoration',
                                    'deleteMethod' => 'forceDeleteDecorationAction',
                                ],
                                'soundSystems' => [
                                    'collection' => $soundSystems,
                                    'type' => 'Sound System',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreSoundSystem',
                                    'deleteMethod' => 'forceDeleteSoundSystem',
                                ],
                                'liveMusic' => [
                                    'collection' => $liveMusic,
                                    'type' => 'Live Music',
                                    'badge' => 'bg-success',
                                    'restoreMethod' => 'restoreLiveMusic',
                                    'deleteMethod' => 'forceDeleteLiveMusic',
                                ],
                                'ceremonialEvents' => [
                                    'collection' => $ceremonialEvents,
                                    'type' => 'Ceremonial Event',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreCeremonialEvent',
                                    'deleteMethod' => 'forceDeleteCeremonialEvent',
                                ],
                                'fotos' => [
                                    'collection' => $fotos,
                                    'type' => 'Foto',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreFoto',
                                    'deleteMethod' => 'forceDeleteFoto',
                                ],
                                'caterings' => [
                                    'collection' => $caterings,
                                    'type' => 'Catering',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreCatering',
                                    'deleteMethod' => 'forceDeleteCatering',
                                ],
                                'teamLanoers' => [
                                    'collection' => $teamLanoers,
                                    'type' => 'Team Lanoer',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreTeamLanoer',
                                    'deleteMethod' => 'forceDeleteTeamLanoer',
                                ],
                                'sliders' => [
                                    'collection' => $sliders,
                                    'type' => 'Slider',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreSlider',
                                    'deleteMethod' => 'forceDeleteSlider',
                                ],
                                'testimonials' => [
                                    'collection' => $testimonials,
                                    'type' => 'Testimoni',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreTestimoni',
                                    'deleteMethod' => 'forceDeleteTestimoni',
                                ],
                                'clients' => [
                                    'collection' => $clients,
                                    'type' => 'Client',
                                    'badge' => 'bg-info',
                                    'restoreMethod' => 'restoreClient',
                                    'deleteMethod' => 'forceDeleteClient',
                                ],
                            ];
                        @endphp

                        @foreach ($items as $key => $item)
                            @forelse($item['collection'] as $model)
                                <tr>
                                    <td><span class="badge {{ $item['badge'] }}">{{ $item['type'] }}</span></td>
                                    <td>
                                        @if ($key === 'fotos')
                                            <img src="{{ asset('storage/back/images/album/foto/' . $model->image) }}"
                                                alt="{{ $model->name }}" class="img-fluid" style="width: 100px;">
                                        @elseif ($key === 'teamLanoers')
                                            <img src="{{ asset('storage/back/images/team/' . $model->image) }}"
                                                alt="{{ $model->name }}" class="img-fluid" style="width: 100px;">
                                        @elseif ($key === 'sliders')
                                            <img src="{{ asset('storage/back/images/slider/' . $model->image) }}"
                                                alt="{{ $model->title }}" class="img-fluid" style="width: 100px;">
                                        @elseif ($key === 'testimonials')
                                            <img src="{{ asset($model->image) }}" alt="{{ $model->name }}"
                                                class="img-fluid" style="width: 100px;">
                                        @elseif ($key === 'clients')
                                            <img src="{{ $model->image }}" alt="{{ $model->name }}" class="img-fluid"
                                                style="width: 100px;">
                                        @else
                                            {{ $model->name }}
                                        @endif


                                    </td>
                                    <td>
                                        @if ($key === 'fotos')
                                            {!! Str::limit($model->title, 10) !!}
                                        @elseif ($key === 'teamLanoers')
                                            {!! Str::limit($model->name, 10) !!}
                                        @elseif ($key === 'sliders')
                                            {!! Str::limit($model->title, 10) !!}
                                        @elseif ($key === 'testimonials')
                                            {!! Str::limit($model->name, 10) !!}
                                        @elseif ($key === 'clients')
                                            {!! Str::limit($model->name, 10) !!}
                                        @else
                                            {!! Str::limit($model->description, 10) !!}
                                        @endif

                                    </td>
                                    <td>{{ $model->deleted_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($model)
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="{{ $item['restoreMethod'] }}({{ $model->id }})">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="{{ $item['deleteMethod'] }}({{ $model->id }})">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                @if ($type === 'all' || $type === $key)
                                    <tr>
                                        <td colspan="5" class="text-center">No deleted
                                            {{ strtolower($item['type']) }}s found.</td>
                                    </tr>
                                @endif
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                @foreach ($items as $key => $item)
                    @if ($type === 'all' || $type === $key)
                        {{ $item['collection']->links() }}
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const deleteHandlers = {
            'forceDelete': 'forceDeleteAction',
            'forceDeleteWedding': 'forceDeleteWeddingAction',
            'forceDeleteDecoration': 'forceDeleteDecorationAction',
            'forceDeleteSoundSystem': 'forceDeleteSoundSystemAction',
            'forceDeleteLiveMusic': 'forceDeleteLiveMusicAction',
            'forceDeleteCeremonialEvent': 'forceDeleteCeremonialEventAction',
            'forceDeleteFoto': 'forceDeleteFotoAction',
            'forceDeleteCatering': 'forceDeleteCateringAction',
            'forceDeleteTeamLanoer': 'forceDeleteTeamLanoerAction',
            'forceDeleteSlider': 'forceDeleteSliderAction',
            'forceDeleteTestimoni': 'forceDeleteTestimoniAction',
            'forceDeleteClient': 'forceDeleteClientAction'
        };

        Object.keys(deleteHandlers).forEach(eventName => {
            window.addEventListener(eventName, function(event) {
                swal.fire({
                    title: event.detail.title,
                    html: event.detail.html,
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6',
                    width: 300,
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.value) {
                        window.Livewire.emit(deleteHandlers[eventName], event.detail.id)
                    }
                });
            });
        });
    </script>
@endpush
