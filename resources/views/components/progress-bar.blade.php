@props(['value' => 0, 'color' => 'auto'])
@php
$percent = min(100, max(0, (float) $value));

$colorMap = [
    'indigo' => 'bg-indigo-600',
    'emerald' => 'bg-emerald-600',
    'amber' => 'bg-amber-600',
    'red' => 'bg-red-600',
    'blue' => 'bg-blue-600',
];

if ($color === 'auto') {
    $barColor = match (true) {
        $percent >= 70 => $colorMap['emerald'],
        $percent >= 40 => $colorMap['amber'],
        default => $colorMap['red'],
    };
} else {
    $barColor = $colorMap[$color] ?? $colorMap['indigo'];
}
@endphp
<div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
    <div class="h-full rounded-full {{ $barColor }} transition-all" style="width: {{ $percent }}%"></div>
</div>
