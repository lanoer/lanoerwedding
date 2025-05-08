<div>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#role_modal">Add Role <i class='bx bx-plus'></i></button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Roles</h4>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="search" class="form-control form-control-sm" placeholder="Search"
                                    wire:model.debounce.300ms="searchRole">
                                <button class="btn btn-secondary">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Guard</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('konfigurasi.roles.show', $role->id) }}">Show</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click.prevent='editRole({{ $role->id }})'>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        wire:click.prevent='deleteRole({{ $role->id }})'>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade bs-example-modal-center" id="role_modal" tabindex="-1" role="dialog"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="modal-content" method="POST"
                    @if ($updateRoleMode) wire:submit.prevent='updateRole()' @else
                    wire:submit.prevent='addRole()' @endif>

                    <div class="modal-header">
                        <h5 class="modal-title">{{ $updateRoleMode ? 'Updated Role' : 'Add Role' }}</h5>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        @if ($updateRoleMode)
                            <input type="hidden" wire:model='selected_role_id'>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Role name</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter Role name" wire:model='name'>
                            <span class="text-danger">
                                @error('name')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Guard name</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter Guard name" wire:model='guard_name'>
                            <span class="text-danger">
                                @error('guard_name')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm me-2 btn-warning"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="btn btn-sm me-2 btn-primary">{{ $updateRoleMode ? 'Update' : 'Save' }}</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
