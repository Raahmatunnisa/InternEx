{{--
    Progress bar dengan label & persentase di atasnya, warna otomatis
    mengikuti nilai: merah (<40%), kuning (40-69%), hijau (>=70%).
--}}
@props(['value' => 0, 'label' => null, 'icon' => null])
@php
    $percent = (int) max(0, min(100, (float) $value));

    $textColor = match (true) {
        $percent >= 70 => 'text-emerald-600',
        $percent >= 40 => 'text-amber-600',
        default => 'text-red-600',
    };
@endphp
<div>
    <div class="flex items-center justify-between mb-1">
        <span class="text-xs font-medium text-slate-500 flex items-center gap-1">
            @if($icon)<i data-lucide="{{ $icon }}" class="w-3.5 h-3.5"></i>@endif
            {{ $label }}
        </span>
        <span class="text-xs font-semibold {{ $textColor }}">{{ $percent }}%</span>
    </div>
    <x-progress-bar :value="$percent" color="auto" />
</div>
