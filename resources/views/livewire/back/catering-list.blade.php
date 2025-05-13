<div>
    <div class="app-container container-xxl">


        <div class="row row-cards">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            All Catering
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
                            <a href="{{ route('catering.create') }}" class="btn btn-primary">Add
                                Catering</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>No</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="w-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($caterings as $c=>$catering)
                                <tr>
                                    <td>{{ $c + 1 }}</td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                style="background-image: url('{{ asset('storage/back/images/catering/' . $catering->image) }}');
                                    width: 50px; height: 50px; background-size: cover; background-position: center;"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            {!! Str::limit($catering->name, 15, ' ...') !!}
                                        </div>
                                    </td>
                                    <td class="text-muted">
                                        {!! Str::limit($catering->description, 15, ' ...') !!}
                                    </td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">

                                            <a href="#" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                                data-bs-target="#cateringModal{{ $catering->id }}"
                                                data-bs-placement="top" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('catering.edit', [$catering->id]) }}"
                                                class="btn btn-sm btn-warning ">Edit</a>

                                            <a href=""
                                                wire:click.prevent='deleteCatering({{ $catering->id }}, "{{ $catering->name }}")'
                                                class="btn btn-sm btn-danger" style="margin-left: 3px">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal untuk event ini -->
                                <div class="modal fade" id="cateringModal{{ $catering->id }}" tabindex="-1"
                                    aria-labelledby="cateringModalLabel{{ $catering->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cateringModalLabel{{ $catering->id }}">
                                                    {{ $catering->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('storage/back/images/catering/' . $catering->image) }}"
                                                            class="img-fluid rounded" alt="{{ $catering->name }}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="mb-3">{{ $catering->name }}</h4>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Description:</h6>
                                                            <p>{!! $catering->description !!}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Created At:</h6>
                                                            <p>{{ $catering->created_at->format('d M Y H:i') }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Updated At:</h6>
                                                            <p>{{ $catering->updated_at->format('d M Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">No Catering found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row mt-4">
            {{ $caterings->links() }}
        </div>
    </div>

</div>
