<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Indexing Google & Bingg</h4>
            </div>
            <div class="card-body">
                @if (session()->has('message'))
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle"></i>
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger mt-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('error') }}
                    </div>
                @endif
                <form wire:submit.prevent="submitUrls">
                    <div class="form-group">
                        <label for="urls">URLs</label>
                        <textarea id="urls" class="form-control @error('urls') is-invalid @enderror" wire:model="urls" rows="5"
                            placeholder="Enter one or more URLs, separated by new lines"></textarea>
                        @error('urls')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-3 d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-success" wire:click="requestIndexing('URL_UPDATED')"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="requestIndexing('URL_UPDATED')">
                                    <i class="fab fa-google"></i> Request Indexing Google
                                </span>
                                <span wire:loading wire:target="requestIndexing('URL_UPDATED')">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Submitting...
                                </span>
                            </button>
                            <button type="button" class="btn btn-info" wire:click="getStatus"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="getStatus">
                                    <i class="fas fa-exclamation-circle"></i> Get Status
                                </span>
                                <span wire:loading wire:target="getStatus">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Submitting...
                                </span>
                            </button>
                        </div>
                        <button type="button" class="btn btn-danger" wire:click="requestIndexing('URL_DELETED')"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="requestIndexing('URL_DELETED')">
                                <i class="fas fa-trash"></i> Request Deletion
                            </span>
                            <span wire:loading wire:target="requestIndexing('URL_DELETED')">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
