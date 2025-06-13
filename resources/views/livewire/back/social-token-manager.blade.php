<div>
    <h2 class="mb-4">Manajemen Pinterest Token</h2>

    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" wire:click="$emit('resetForm')" data-bs-toggle="modal"
        data-bs-target="#tokenModal">
        Tambah Token
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Provider</th>
                <th>Access Token</th>
                <th>Expires At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tokens as $token)
            <tr>
                <td>{{ $token->provider }}</td>
                <td>{{ Str::limit($token->access_token, 50) }}</td>
                <td>{{ $token->expires_at }}</td>
                <td>
                    <button class="btn btn-sm btn-info" wire:click="$emit('editToken', {{ $token->id }})"
                        data-bs-toggle="modal" data-bs-target="#tokenModal">Edit</button>
                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $token->id }})"
                        onclick="confirm('Hapus token ini?') || event.stopImmediatePropagation()">Hapus</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Belum ada token.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="tokenModal" tabindex="-1" aria-labelledby="tokenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="save">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tokenModalLabel">{{ $editId ? 'Edit' : 'Tambah' }} Token</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="provider" class="form-label">Provider</label>
                            <input type="text" id="provider" class="form-control" wire:model="provider">
                            @error('provider') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="access_token" class="form-label">Access Token</label>
                            <textarea id="access_token" class="form-control" wire:model="access_token"
                                rows="3"></textarea>
                            @error('access_token') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires At</label>
                            <input type="datetime-local" id="expires_at" class="form-control" wire:model="expires_at">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetForm" class="btn btn-secondary"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>