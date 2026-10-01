{{--
    PhotoCard: card foto + copywriting singkat, dipakai di sisi form (mis. Tambah Aktivitas).
    Props: context, quote, alt
--}}
@props([
    'context',
    'quote' => null,
    'alt' => 'Ilustrasi kegiatan magang',
])
@php
$url = \App\Support\Photos::url($context);
@endphp
<div {{ $attributes->merge(['class' => 'card overflow-hidden']) }}>
    <div class="relative h-48 w-full">
        @if($url)
            <img src="{{ $url }}" alt="{{ $alt }}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/70 to-transparent"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-[#0F172A] flex items-center justify-center">
                <i data-lucide="image" class="w-8 h-8 text-white/40"></i>
            </div>
        @endif
    </div>
    @if($quote)
        <div class="p-5">
            <p class="text-sm font-medium text-slate-700 italic">&ldquo;{{ $quote }}&rdquo;</p>
        </div>
    @endif
</div>
