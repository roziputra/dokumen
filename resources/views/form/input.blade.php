<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" class="@error($name) is-invalid @enderror form-control" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value ?? null) }}" placeholder="{{ $label }}">
    @error($name)
    <div class="error invalid-feedback">{{ $message }}</div>
    @enderror
</div>