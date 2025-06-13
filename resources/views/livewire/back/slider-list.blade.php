<div>
    <style>
        #sortable_slider tr.dragging {
            opacity: 0.5;
        }
    </style>
    <div class="app-container container-xxl">
        <div class="row row-cards">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            All Slider
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="card-toolbar">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." wire:model='search'
                                style="padding-right: 40px;">
                            <span class="input-group-text"
                                style="position: absolute; right: 10px; border: none; background: transparent; z-index: 1000;">
                                <i class="mdi mdi-magnify"></i>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            Show
                            <div class="mx-2 d-inline-block ">
                                <select wire:model.live='perPage' class="form-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('slider.create') }}" class="btn btn-primary">Add
                                Slider</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action Link</th>
                                <th>Active Slider</th>
                                <th>Active Card</th>
                                <th class="w-1">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable_slider" wire:ignore>
                            @forelse ($sliders as $slider)
                            <tr data-index="{{ $slider->id }}" data-ordering="{{ $slider->ordering }}" draggable="true"
                                wire:key="slider-{{ $slider->id }}">
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2"
                                            style="background-image: url('{{ asset('storage/back/images/slider/' . $slider->image) }}');
                                                                                        width: 50px; height: 50px; background-size: cover; background-position: center;"></span>
                                    </div>
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>{!! Str::limit($slider->desc_short, 15, ' ...') !!}</td>
                                <td>
                                    <div>
                                        <a href="{{ $slider->action_link }}" target="_blank">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @livewire('back.slider-status', ['model' => $slider, 'field' => 'isActive_slider'],
                                    key($slider->id))
                                </td>
                                <td>
                                    @livewire('back.slider-status-card', ['model' => $slider, 'field' =>
                                    'isActive_card'], key($slider->id))
                                </td>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <a href="{{ route('slider.edit', [$slider->id]) }}"
                                            class="btn btn-sm btn-warning me-2" data-bs-toggle="tooltip" title="Edit">
                                            Edit
                                        </a>
                                        <a href=""
                                            wire:click.prevent="deleteSlider({{ $slider->id }}, '{{ $slider->title }}')"
                                            class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"><span class="text-danger">Slider Not Found!</span></td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row mt-4">
            {{ $sliders->links() }}
        </div>
    </div>

</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('sortable_slider');
        if (!el) return;

        new Sortable(el, {
            animation: 150,
            handle: 'td',
            onEnd: function () {
                const positions = [];
                el.querySelectorAll('tr').forEach((row, index) => {
                    positions.push([
                        row.getAttribute('data-index'),
                        index + 1
                    ]);
                });
                console.log(positions);
                Livewire.emit('updateSliderOrdering', positions);
            }
        });
    });
</script>
@endpush