@props(['value'])

<label {{ $attributes->merge([
    'class' => 'block text-base font-semibold text-gray-800'
]) }}>
    {{ $value ?? $slot }}
</label>