@props(['type' => 'info'])
@php
$map = [
    'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
    'error' => 'bg-red-50 text-red-800 border-red-200',
    'warning' => 'bg-amber-50 text-amber-800 border-amber-200',
    'info' => 'bg-blue-50 text-blue-800 border-blue-200',
];
$classes = $map[$type] ?? $map['info'];
@endphp
<div {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-xl border px-4 py-3 text-sm $classes"]) }}>
    {{ $slot }}
</div>
