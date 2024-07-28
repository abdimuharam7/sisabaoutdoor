@props([
    'id' => '',
    'name' => '',
    'class' => '',
    'options' => [],
    'placeholder' => '',
    'value' => ''
])
<select id="field-{{ $id }}" class="block mt-1 w-full rounded-lg border-gray-300 {{ $class }}" name="{{ $name }}">
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach($options as $opt)
        <option value="{{ $opt['value'] }}" {{ (old($name, ($value ?? '')) == $opt['value']) ? 'selected' : '' }}>{{ $opt['label'] }}</option>
    @endforeach
</select>