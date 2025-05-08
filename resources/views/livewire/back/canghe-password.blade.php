<div>
    <form action="" wire:submit.prevent="ChangePassword()">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="current_password">Old Password</label>
                    <div class="input-group">
                        <input id="password_input" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            placeholder="current_password" autocomplete="off" wire:model="current_password">
                        <button class="btn btn-secondary" type="button" id="toggle_button"
                            onclick="togglePasswordVisibility('toggle_button', 'password_input')">
                            <i class="mdi mdi-eye-off" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="new_password">New Password</label>
                    <div class="input-group">
                        <input id="password_input1" type="password"
                            class="form-control @error('new_password') is-invalid @enderror" placeholder="new_password"
                            autocomplete="off" wire:model="new_password">
                        <button class="btn btn-secondary" type="button" id="toggle_button1"
                            onclick="togglePasswordVisibility('toggle_button1', 'password_input1')">
                            <i class="mdi mdi-eye-off" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <div class="input-group">
                        <input id="password_input2" type="password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            placeholder="confirm_password" autocomplete="off" wire:model="confirm_password">
                        <button class="btn btn-secondary" type="button" id="toggle_button2"
                            onclick="togglePasswordVisibility('toggle_button2', 'password_input2')">
                            <i class="mdi mdi-eye-off" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('confirm_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">
            <span wire:loading wire:target="ChangePassword" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <span wire:loading.remove wire:target="ChangePassword">Save</span>
            <span wire:loading wire:target="ChangePassword">Saving...</span>
        </button>
    </form>
</div>
@push('scripts')
    <script>
        function togglePasswordVisibility(buttonId, inputId) {
            let button = document.getElementById(buttonId);
            let input = document.getElementById(inputId);

            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<i class="mdi mdi-eye" aria-hidden="true"></i>';
            } else {
                input.type = 'password';
                button.innerHTML = '<i class="mdi mdi-eye-off" aria-hidden="true"></i>';
            }
        }
    </script>
@endpush
