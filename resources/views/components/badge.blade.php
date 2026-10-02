{{--
    Badge status dengan icon Lucide (bukan emoji/simbol Unicode) + label teks.
    Icon per status mengikuti standar icon system aplikasi.
--}}
@props(['status' => 'default', 'icon' => null])
@php
$colorMap = [
    'submitted' => 'bg-blue-100 text-blue-700',
    'approved' => 'bg-emerald-100 text-emerald-700',
    'rejected' => 'bg-red-100 text-red-700',
    'draft' => 'bg-slate-100 text-slate-600',
    'reviewed' => 'bg-amber-100 text-amber-700',
    'revision' => 'bg-amber-100 text-amber-700',
    'hadir' => 'bg-emerald-100 text-emerald-700',
    'terlambat' => 'bg-amber-100 text-amber-700',
    'izin' => 'bg-blue-100 text-blue-700',
    'sakit' => 'bg-purple-100 text-purple-700',
    'alpha' => 'bg-red-100 text-red-700',
    'lupa_masuk' => 'bg-amber-100 text-amber-700',
    'lupa_pulang' => 'bg-amber-100 text-amber-700',
    'active' => 'bg-emerald-100 text-emerald-700',
    'completed' => 'bg-slate-200 text-slate-600',
    'default' => 'bg-slate-100 text-slate-600',
];

$iconMap = [
    'submitted' => 'send',
    'approved' => 'check-circle-2',
    'rejected' => 'circle-x',
    'draft' => 'file-text',
    'reviewed' => 'eye',
    'revision' => 'refresh-cw',
    'hadir' => 'check-circle-2',
    'terlambat' => 'circle-alert',
    'izin' => 'calendar-check',
    'sakit' => 'circle-alert',
    'alpha' => 'circle-x',
    'lupa_masuk' => 'log-in',
    'lupa_pulang' => 'log-out',
    'active' => 'check-circle-2',
    'completed' => 'circle-check',
    'default' => 'circle',
];

$classes = $colorMap[$status] ?? $colorMap['default'];
$resolvedIcon = $icon ?? ($iconMap[$status] ?? $iconMap['default']);
@endphp
<span {{ $attributes->merge(['class' => "badge $classes"]) }}>
    <i data-lucide="{{ $resolvedIcon }}" class="w-3.5 h-3.5"></i>
    {{ $slot }}
</span>
