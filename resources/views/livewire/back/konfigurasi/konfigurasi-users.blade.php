<div>
    <div class="col-lg-10">

        <div class="card">

            <div class="card-header d-flex flex-column align-items-start bg-primary">
                <div class="d-flex justify-content-between w-100">
                    <div class="input-group input-group-sm position-relative flex-grow-1 me-2">
                        <input type="search" class="form-control form-control-sm" placeholder="Cari..."
                            wire:model.debounce.300ms="search" wire:keydown.enter="search">
                        <i class='bx bx-search-alt position-absolute'
                            style="right: 10px; top: 50%; transform: translateY(-50%);"></i>
                    </div>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add_user_modal"><i
                            class="mdi mdi-plus"></i></button>

                </div>
                <div class="d-flex justify-content-between w-100 mt-3">
                    <div>
                        <select wire:model="perPage" class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    @if ($checkedUser)
                        <button class="btn btn-sm btn-danger" wire:click="deleteSelectedUser()">Bulk Delete
                            {{ count($checkedUser) }}</button>
                    @endif


                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-filter-outline"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupVerticalDrop1">
                            <div class="dropdown-item">
                                <label class="form-label fs-6 ">Role:</label>
                                <select wire:model="roleFilter" class="form-select form-select-solid ">
                                    <option value="">Semua Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="dropdown-item">
                                <label class="form-label fs-6 ">User Status:</label>
                                <select wire:model="FilterUserActive" class="form-select form-select-solid ">
                                    <option value="">Semua User</option>
                                    <option value="1">User Aktif</option>
                                    <option value="0">User Tidak Aktif</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" wire:model="selectAll"></th>
                                <th>No</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Active users</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" wire:model="checkedUser" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                    <td>@livewire('back.user-status', ['model' => $user, 'field' => 'isActive'], key($user->id))
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user->username) }}"
                                            class="btn btn-primary btn-sm" data-toggle="tooltip" title="Lihat User"><i
                                                class="mdi mdi-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm"
                                            wire:click.prevent='editUser({{ $user }})' data-toggle="tooltip"
                                            title="Edit User"><i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm"
                                            wire:click.prevent='deleteUser({{ $user }})' data-toggle="tooltip"
                                            title="Hapus User"><i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $users->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal modal-blur fade" id="add_user_modal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='addAuthor()' method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter name" wire:model='name'>
                            <span class="text-danger">
                                @error('name')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" wire:model='role'>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('role')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="example-text-input"
                                placeholder="Enter email" wire:model='email'>
                            <span class="text-danger">
                                @error('email')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter username" wire:model='username'>
                            <span class="text-danger">
                                @error('username')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" wire:model='jenis_kelamin'
                                class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span class="text-danger">
                                @error('jenis_kelamin')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal modal-blur fade" id="edit_user_modal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='updateUser()' method="post">
                        @csrf
                        <input type="hidden" wire:model='selected_user_id'>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter name" wire:model='name'>
                            <span class="text-danger">
                                @error('name')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter email" wire:model='email'>
                            <span class="text-danger">
                                @error('email')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Enter username" wire:model='username'>
                            <span class="text-danger">
                                @error('username')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" wire:model='role'>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('role')
                                    {!! $message !!}
                                @enderror
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="/back/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
        $(window).on('hidden.bs.modal', function() {
            Livewire.emit('resetForms');
        });

        window.addEventListener('hide_add_user_modal', function(event) {
            $('#add_user_modal').modal('hide');
        });

        window.addEventListener('showEditUserModal', function(event) {
            $('#edit_user_modal').modal('show')
        });
        window.addEventListener('hide_edit_user_modal', function(event) {
            $('#edit_user_modal').modal('hide');
        });
        window.addEventListener('deleteUser', function(event) {
            console.log("Handling deleteUser event", event.detail);
            swal.fire({
                title: event.detail.title,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
            }).then(function(result) {
                if (result.value) {
                    console.log("Emitting deleteUserAction for ID:", event.detail.id);
                    Livewire.emit('deleteUserAction', event.detail.id);
                }
            });
        });
        window.addEventListener('swal:deleteUser', function(event) {
            swal.fire({
                title: event.detail.title,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('deleteCheckedUser', event.detail.checkedIDs);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip(); // Mengaktifkan tooltip Bootstrap
        });
    </script>
@endpush
