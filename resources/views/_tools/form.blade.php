@php
$type = $type ?? 'text';
$prefix = $prefix ?? '';
$name = $name ?? '';
$caption = $caption ?? '';
$value = $value ?? '';
$placeholder = $placeholder ?? '';
$class = $class ?? '';
$attributes = $attributes ?? '';
$rowSize = $rowSize ?? '4';
$defaultOption = $defaultOption ?? '';
$defaultOptionDisabled = $defaultOptionDisabled ?? false;
$options = $options ?? [];
$optionKey = $optionKey ?? '';
$optionValue = $optionValue ?? '';
@endphp

@if ($type == 'text' || $type == 'email' || $type == 'password' || $type == 'file')
    <div class="form-group" id="{{ $prefix.$name.'FormGroup' }}">
        <label for="{{ $prefix.$name }}">{{ $caption }}</label>
        <input type="{{ $type }}" class="form-control {{ $class }}" id="{{ $prefix.$name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}" {!! $attributes !!} autocomplete="off">
    </div>
@elseif ($type == 'checkbox')
    <div class="form-group" id="{{ $prefix.$name.'FormGroup' }}">
        <label class="ckbox" for="{{ $prefix.$name }}">
            <input type="checkbox" id="{{ $prefix.$name }}" name="{{ $name }}" {{ $attributes }}><span>{{ $caption }}</span>
        </label>
    </div>
@elseif ($type == 'textarea')
    <div class="form-group" id="{{ $prefix.$name.'FormGroup' }}">
        <label for="{{ $prefix.$name }}">{{ $caption }}</label>
        <textarea type="{{ $type }}" class="form-control {{ $class }}" rows="{{ $rowSize }}" id="{{ $prefix.$name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes }}>{!! $value !!}</textarea>
    </div>
@elseif ($type == 'select')
    <div class="form-group" id="{{ $prefix.$name.'FormGroup' }}">
        <label for="{{ $prefix.$name }}">{{ $caption }}</label>
        <select name="{{ $name }}" id="{{ $prefix.$name }}" class="form-control {{ $class }}" {{ $attributes }}>
            @if ($defaultOption != '')
                <option value="" {{ $defaultOptionDisabled == true ? 'selected disabled' : '' }}>{{ $defaultOption }}</option>
            @endif
            @foreach($options as $option)
                @php
                    if (is_array($optionValue)) {
                        $optionValues = [];
                        foreach ($optionValue as $item) {
                            array_push($optionValues, $option[$item]);
                        }
                    }
                @endphp
                <option value="{{ $option[$optionKey] }}" {{ $option[$optionKey] == $value ? 'selected' : '' }}>{{ is_array($optionValue) ? join("; ", $optionValues) : $option[$optionValue] }}</option>
            @endforeach
        </select>
    </div>
@endif
