<div>
    <div class="app-container container-xxl">


        <div class="row row-cards">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            All Team Lanoer
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
                            <a href="{{ route('team.create') }}" class="btn btn-primary">Add
                                Team Lanoer</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th class="w-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teams as $t=>$team)
                                <tr>
                                    <td>{{ $t + 1 }}</td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                style="background-image: url('{{ asset('storage/back/images/team/' . $team->image) }}');
                                    width: 50px; height: 50px; background-size: cover; background-position: center;"></span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $team->name }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary', 'bg-dark'][array_rand(['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary', 'bg-dark'])] }}">{{ $team->position }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">

                                            <a href="#" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                                data-bs-target="#teamModal{{ $team->id }}" data-bs-placement="top"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('team.edit', [$team->id]) }}"
                                                class="btn btn-sm btn-warning ">Edit</a>

                                            <a href=""
                                                wire:click.prevent='deleteTeam({{ $team->id }}, "{{ $team->name }}")'
                                                class="btn btn-sm btn-danger" style="margin-left: 3px">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal untuk event ini -->
                                <div class="modal fade" id="teamModal{{ $team->id }}" tabindex="-1"
                                    aria-labelledby="teamModalLabel{{ $team->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="teamModalLabel{{ $team->id }}">
                                                    {{ $team->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('storage/back/images/team/' . $team->image) }}"
                                                            class="img-fluid rounded" alt="{{ $team->name }}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="mb-3">{{ $team->name }}</h4>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Position:</h6>
                                                            <p>{!! $team->position !!}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Social Media:</h6>
                                                            <div class="d-flex gap-3">
                                                                <a href="{{ $team->instagram ?? '#' }}"
                                                                    class="text-decoration-none" target="_blank">
                                                                    <i class="fab fa-instagram fa-lg text-danger"></i>
                                                                </a>
                                                                <a href="{{ $team->tiktok ?? '#' }}"
                                                                    class="text-decoration-none" target="_blank">
                                                                    <svg width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="black"
                                                                        class="fa-lg">
                                                                        <path
                                                                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                                                    </svg>
                                                                </a>
                                                                <a href="{{ $team->twitter ?? '#' }}"
                                                                    class="text-decoration-none" target="_blank">
                                                                    <i class="fab fa-twitter fa-lg text-info"></i>
                                                                </a>
                                                                <a href="{{ $team->facebook ?? '#' }}"
                                                                    class="text-decoration-none" target="_blank">
                                                                    <i class="fab fa-facebook fa-lg text-primary"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="text-muted">Created At:</h6>
                                                            <p>{{ $team->created_at->format('d M Y H:i') }}</p>
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
                                    <td colspan="5" class="text-center text-danger">No Team Lanoer found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row mt-4">
            {{ $teams->links() }}
        </div>
    </div>

</div>
