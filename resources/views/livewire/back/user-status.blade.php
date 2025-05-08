<div>
    <div class="form-check form-switch">
        <label class="form-check-label ms-1">
            <input class="form-check-input" wire:model.lazy="isActive" type="checkbox" role="switch"
                @if ($isActive) checked @endif>
        </label>
    </div>
</div>
