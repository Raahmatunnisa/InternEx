@props(['variant' => 'primary', 'type' => 'button'])
@php
$classes = match($variant) {
    'secondary' => 'btn btn-secondary',
    'success' => 'btn btn-success',
    'danger' => 'btn btn-danger',
    default => 'btn btn-primary',
};
@endphp
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
