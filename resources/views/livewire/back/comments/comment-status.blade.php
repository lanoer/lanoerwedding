<div>
    <div class="form-check form-switch">
        <label class="switch">
            <input class="form-check-input" wire:model.lazy="approved" type="checkbox" role="switch" @if($approved)
                checked @endif @if($approved) disabled @endif>
            <span class="slider round"></span>
        </label>
    </div>
</div>