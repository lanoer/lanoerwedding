<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Indexing Google</h4>
            </div>
            <div class="card-body">
                @if ($googleMessage)
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i>
                    {{ $googleMessage }}
                </div>
                @endif
                @if ($googleError)
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $googleError }}
                </div>
                @endif
                <form wire:submit.prevent="submitUrls">
                    <div class="form-group">
                        <label for="urls">URLs</label>
                        <textarea id="urls" class="form-control @error('urls') is-invalid @enderror" wire:model="urls"
                            rows="5" placeholder="Enter one or more URLs, separated by new lines"></textarea>
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
    <!-- Formulir Bing Indexing (Ditambahkan di bawah formulir Google) -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Bing Indexing</h4>
            </div>
            <div class="card-body">
                @if ($bingMessage)
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i>
                    {{ $bingMessage }}
                </div>
                @endif
                @if ($bingError)
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $bingError }}
                </div> @endif
                <form wire:submit.prevent="submitBingUrls">
                    <div class="form-group">
                        <label for="bingUrls">URLs</label>
                        <textarea id="bingUrls" class="form-control @error('bingUrls') is-invalid @enderror"
                            wire:model="bingUrls" rows="5"
                            placeholder="Enter one or more URLs, separated by new lines"></textarea>
                        @error('bingUrls')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-3 d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-primary"
                                wire:click="requestBingIndexing('URL_UPDATED')" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="requestBingIndexing('URL_UPDATED')">
                                    <i class="fab fa-microsoft"></i> Request Indexing Bing
                                </span>
                                <span wire:loading wire:target="requestBingIndexing('URL_UPDATED')">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Submitting...
                                </span>
                            </button>

                        </div>
                        <button type="button" class="btn btn-danger" wire:click="requestBingDeletion"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="requestBingDeletion">
                                <i class="fas fa-trash"></i> Request Deletion
                            </span>
                            <span wire:loading wire:target="requestBingDeletion">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Submitting...
                            </span> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>