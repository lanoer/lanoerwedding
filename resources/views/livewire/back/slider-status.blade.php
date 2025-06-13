<div>
    <div class="form-check form-switch">
        <label class="form-check-label ms-1">
            <input class="form-check-input" wire:model.lazy="isActive_slider" type="checkbox" role="switch"
                @if ($isActive_slider) checked @endif>
        </label>
    </div>
</div>
