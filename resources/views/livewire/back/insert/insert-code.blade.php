<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Insert Code</h4>
                </div>
                <div class="card-body">
                    <form action="" class="form-horizontal" wire:submit.prevent="storeCode()">
                        <div class="form-group row mb-2">
                            <label for="gsc" class="col-sm-2 col-form-label">Google Searh Console</label>
                            <div class="col-sm-10">
                                <input type="text" name="gsc" id="gsc"
                                    class="form-control @error('gsc') is-invalid @enderror" wire:model="gsc"
                                    placeholder="Masukkan kode Google Searh Console">
                                @error('gsc')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="gtag_analytics_id" class="col-sm-2 col-form-label">Gtag Analytics Id</label>
                            <div class="col-sm-10">
                                <input type="text" name="gtag_analytics_id" id="gtag_analytics_id"
                                    class="form-control @error('gtag_analytics_id') is-invalid @enderror"
                                    wire:model="gtag_analytics_id" placeholder="Masukkan kode gtag_analytics_id">
                                @error('gtag_analytics_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="gtag_analytics" class="col-sm-2 col-form-label">Gtag Analytics</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="gtag_analytics" id="gtag_analytics" cols="30" rows="10"
                                    class="form-control @error('gtag_analytics') is-invalid @enderror" wire:model="gtag_analytics"
                                    placeholder="Masukkan kode Google Analytics">
                                </textarea>
                                @error('gtag_analytics')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="gtag_header" class="col-sm-2 col-form-label">Gtag Manager Header</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="gtag_header" id="gtag_header" cols="30" rows="10"
                                    class="form-control @error('gtag_header') is-invalid @enderror" wire:model="gtag_header"
                                    placeholder="Masukkan kode Google Tag Manager">
                                </textarea>

                                @error('gtag_header')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="gtag_body" class="col-sm-2 col-form-label">Gtag Manager Body</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="gtag_body" id="gtag_body" cols="30" rows="10"
                                    class="form-control @error('gtag_body') is-invalid @enderror" wire:model="gtag_body"
                                    placeholder="Masukkan kode Google Tag Manager">
                                </textarea>

                                @error('gtag_body')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="bing" class="col-sm-2 col-form-label">Bing</label>
                            <div class="col-sm-10">
                                <input type="text" name="bing" id="bing"
                                    class="form-control @error('bing') is-invalid @enderror" wire:model="bing"
                                    placeholder="Masukkan kode Bing">
                                @error('bing')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="yandex" class="col-sm-2 col-form-label">Yandex</label>
                            <div class="col-sm-10">
                                <input type="text" name="yandex" id="yandex"
                                    class="form-control @error('yandex') is-invalid @enderror" wire:model="yandex"
                                    placeholder="Masukkan kode Yandex">
                                @error('yandex')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="baidu" class="col-sm-2 col-form-label">Baidu</label>
                            <div class="col-sm-10">
                                <input type="text" name="baidu" id="baidu"
                                    class="form-control @error('baidu') is-invalid @enderror" wire:model="baidu"
                                    placeholder="Masukkan kode Baidu">
                                @error('baidu')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="pinterest" class="col-sm-2 col-form-label">Pinterest</label>
                            <div class="col-sm-10">
                                <input type="text" name="pinterest" id="pinterest"
                                    class="form-control @error('pinterest') is-invalid @enderror"
                                    wire:model="pinterest" placeholder="Masukkan kode Pinterest">
                                @error('pinterest')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class=" d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    <span wire:loading.remove wire:target="storeCode">Save</span>
                                    <span wire:loading wire:target="storeCode"
                                        class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    <span wire:loading wire:target="storeCode">Saving...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
