<div>
    <form wire:submit.prevent="ChangePassword">
        <div class="row mt-4">
            <!-- Current password -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Old Password</label>
                    <div class="input-group">
                        <input id="password_input" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            wire:model="current_password">
                        <button class="btn btn-secondary" type="button"
                            onclick="togglePasswordVisibility('toggle_button', 'password_input')">
                            <i class="mdi mdi-eye-off"></i>
                        </button>
                    </div>
                    @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- New password -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <input id="password_input1" type="password"
                            class="form-control @error('new_password') is-invalid @enderror" wire:model="new_password">
                        <button class="btn btn-secondary" type="button"
                            onclick="togglePasswordVisibility('toggle_button1', 'password_input1')">
                            <i class="mdi mdi-eye-off"></i>
                        </button>
                    </div>
                    @error('new_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Confirm password -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input id="password_input2" type="password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            wire:model="confirm_password">
                        <button class="btn btn-secondary" type="button"
                            onclick="togglePasswordVisibility('toggle_button2', 'password_input2')">
                            <i class="mdi mdi-eye-off"></i>
                        </button>
                    </div>
                    @error('confirm_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <span wire:loading wire:target="ChangePassword" class="spinner-border spinner-border-sm"
                role="status"></span>
            <span wire:loading.remove wire:target="ChangePassword">Save</span>
        </button>
    </form>

    <!-- Bootstrap Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toast-message">Password berhasil diubah</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility(buttonId, inputId) {
        let input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
        document.getElementById(buttonId).innerHTML =
            input.type === 'text' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>';
    }

    window.addEventListener('passwordChanged', function () {
        // Tampilkan toast
        const toastEl = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toast-message');
        toastMsg.textContent = 'Password berhasil diubah. Mengarahkan ke login...';
        toastEl.classList.remove('bg-danger');
        toastEl.classList.add('bg-success');
        new bootstrap.Toast(toastEl).show();

        // Redirect ke login setelah 2 detik
        setTimeout(() => {
            window.location.href = "{{ route('auth.login') }}";
        }, 2000);
    });

    window.addEventListener('showToast', function (event) {
        const toastEl = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toast-message');
        toastMsg.textContent = event.detail.message || 'Terjadi kesalahan';
        toastEl.classList.remove('bg-success');
        toastEl.classList.add('bg-danger');
        new bootstrap.Toast(toastEl).show();
    });
</script>
@endpush