<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select id="{{ $name }}" class="@error($name) is-invalid @enderror form-control select2" name="{{ $name }}" style="width: 100%;">
        <option value="">Choose {{ $label }}</option>
        @if ($type ?? null === 'array')
            @foreach ($options as $index => $option)
                @if (!$loop->first)
                @if ($index == old($name, $value ?? null))
                <option selected @if (isset($optionGroup)) data-group="{{ $option[$optionGroup] }}" @endif value="{{ $index }}"> {{ $option[$optionValueColumn ?? 'value'] ?? $option}}</option>
                @else
                <option @if (isset($optionGroup)) data-group="{{ $option[$optionGroup] }}" @endif value="{{ $index }}"> {{ $option[$optionValueColumn ?? 'value'] ?? $option }}</option>
                @endif
                @endif
            @endforeach
        @else
            @foreach ($options as $option)
                @if ($option->{$optionKeyColumn ?? 'id'} == old($name, $value ?? null))
                <option selected @if (isset($optionGroup)) data-group="{{ $option->{$optionGroup} }}" @endif value="{{ $option->{$optionKeyColumn ?? 'id'} }}"> {{ $option->{$optionValueColumn ?? 'name'} }}</option>
                @else
                <option @if (isset($optionGroup)) data-group="{{ $option->{$optionGroup} }}" @endif value="{{ $option->{$optionKeyColumn ?? 'id'} }}"> {{ $option->{$optionValueColumn ?? 'name'} }}</option>
                @endif
            @endforeach
        @endif
    </select>
    @error($name)
    <span class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
@if (isset($optionGroup, $filterGroup))
@push('js')
    <script type="text/javascript">
        $(function () {
            var filterGroup = '#{{$filterGroup}}';
            $(filterGroup).change(function() {
                // filter role options
                var valueGroup = $(this).val();
                var grup = '#{{$name}}';
                $(grup + ' option').hide();
                $(grup).val('');
                $(grup + ' option[data-group="' + valueGroup + '"]').show();
            })
        });
    </script>
@endpush
@endif