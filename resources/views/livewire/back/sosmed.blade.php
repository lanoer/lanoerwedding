<div>
    <form wire:submit.prevent="updateSosmed()">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="fb">Facebook</label>
                    <input type="text" class="form-control" id="fb" wire:model="fb" placeholder="Facebook">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="ig">Instagram</label>
                    <input type="text" class="form-control" id="ig" placeholder="Instagram" wire:model="ig">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="tw">Twitter</label>
                    <input type="text" class="form-control" id="tw" placeholder="Twitter" wire:model="tw">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="ig">Instagram</label>
                    <input type="text" class="form-control" id="ig" placeholder="Instagram" wire:model="ig">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="tik">Tiktok</label>
                    <input type="text" class="form-control" id="tik" placeholder="Tiktok" wire:model="tik">
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading wire:target="updateSosmed" class="spinner-border spinner-border-sm"
                        role="status" aria-hidden="true"></span>
                    <span wire:loading.remove wire:target="updateSosmed">Save</span>
                    <span wire:loading wire:target="updateSosmed">Saving...</span>
                </button>
            </div>
        </div>

    </form>
</div>
