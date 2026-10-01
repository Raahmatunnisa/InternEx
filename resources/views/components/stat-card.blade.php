@props(['label', 'value', 'icon' => 'activity', 'color' => 'indigo'])
@php
$colorMap = [
    'indigo' => ['bg-indigo-50', 'text-indigo-600'],
    'emerald' => ['bg-emerald-50', 'text-emerald-600'],
    'amber' => ['bg-amber-50', 'text-amber-600'],
    'red' => ['bg-red-50', 'text-red-600'],
    'blue' => ['bg-blue-50', 'text-blue-600'],
];
[$bg, $text] = $colorMap[$color] ?? $colorMap['indigo'];
@endphp
<div class="card p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">{{ $label }}</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $value }}</p>
        </div>
        <div class="w-11 h-11 rounded-xl {{ $bg }} flex items-center justify-center">
            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $text }}"></i>
        </div>
    </div>
</div>
