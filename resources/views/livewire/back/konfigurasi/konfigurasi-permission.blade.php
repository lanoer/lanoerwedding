<div>
    <div class="col-lg-8">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addsatuPermissionModal"><i
                class="mdi mdi-plus"></i> Tambah Permission</button>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="quote">Permissions List</div>
                <div class="col-md-6">
                    <style>
                        .input-group .form-control {
                            padding-right: 30px;
                        }

                        .bx {
                            color: #aaa;
                        }
                    </style>
                    <div class="input-group input-group-sm position-relative">
                        <input type="search" class="form-control" placeholder="Cari..."
                            wire:model.debounce.300ms="searchTerm" wire:keydown.enter="searchPermissions">
                        <i class='bx bx-search-alt position-absolute'
                            style="right: 10px; top: 50%; transform: translateY(-50%);"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-reponsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>
                                        @foreach ($item['permissions'] as $permission)
                                            <span class="badge badge-soft-primary font-size-12">
                                                {{ $permission }}
                                                <a
                                                    onclick="confirmDelete('{{ $item['id'] }}', '{{ $permission }}')">
                                                    <i class="fas fa-times text-danger ml-2"
                                                        style="margin-left: 8px;"></i>
                                                </a>
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary"
                                            wire:click.prevent="showModal({{ $item['id'] }})"><i
                                                class="mdi mdi-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambahkan permissions kepada role-->
    <div wire:ignore.self class="modal fade" id="addPermissionModal" tabindex="-1"
        aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Tambah Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if (is_null($availablePermissions) || $availablePermissions->isEmpty())
                        <div></div>

                        @if (strlen($searchTerm) > 0)
                            <div class="alert alert-danger" role="alert">
                                Tidak ada permissions yang ditemukan untuk "{{ $searchTerm }}".
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                Semua permissions sudah diterapkan.
                            </div>
                        @endif
                    @else
                        <div class="col-md-3 mb-3">

                            <input type="text" class="form-control" placeholder="Cari permission..."
                                wire:model.debounce.300ms="searchTerm">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectAll"
                                        wire:change="toggleSelectAll">
                                    <label class="form-check-label fw-bolder" for="checkAll">Pilih Semua</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            @forelse($availablePermissions as $permission)
                                <div class="col-md-4 mt-2">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}"
                                            wire:model="selectedPermissions">
                                        <label class="form-check-label">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>

                            @empty
                                <div>Tidak ada permissions yang ditemukan.</div>
                            @endforelse
                        </div>

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="addPermissionsToRole">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Permission -->
    <div wire:ignore.self class="modal fade" id="addsatuPermissionModal" tabindex="-1"
        aria-labelledby="addsatuPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addsatuPermissionModalLabel">Tambah Permission Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createPermission">
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Nama Permission</label>
                            <input type="text" class="form-control" id="permissionName"
                                wire:model.defer="permissionName">
                            @error('permissionName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
        function confirmDelete(roleId, permissionName) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Tindakan ini melepas permission dari role ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.call('deletePermission', roleId, permissionName);
                }
            })
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('showModal', event => {
                $(event.detail.modalId).modal('show');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('alert', message => {
                alert(message);
            });

            window.addEventListener('close-modal', event => {
                const modal = bootstrap.Modal.getInstance(document.getElementById(
                'addsatuPermissionModal'));
                modal.hide();
            });
        });
    </script>
@endpush
