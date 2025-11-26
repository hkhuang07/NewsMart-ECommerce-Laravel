{{-- resources/views/users/partials/profile-edit-item.blade.php --}}

<div class="detail-item">
    <div class="detail-icon"><i class="{{ $icon }}"></i></div>
    <div class="form-group flex-grow-1">
        <label class="detail-label d-block" for="{{ $name }}">{{ $label }}:</label>
        <input 
            type="{{ $type ?? 'text' }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            class="form-control @error($name) is-invalid @enderror"
            @if ($name === 'email') readonly @endif>
        @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>