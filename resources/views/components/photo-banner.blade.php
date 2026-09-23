{{--
    PhotoBanner: banner lebar/tipis untuk header halaman (mis. Logbook, Peserta Magang, Periode).
    Props: context, title, subtitle, alt, height class
--}}
@props([
    'context',
    'title' => null,
    'subtitle' => null,
    'alt' => 'Ilustrasi kegiatan magang',
    'heightClass' => 'h-32 sm:h-40',
])
@php
$url = \App\Support\Photos::url($context);
@endphp
<div {{ $attributes->merge(['class' => "relative w-full $heightClass rounded-2xl overflow-hidden mb-6"]) }}>
    @if($url)
        <img src="{{ $url }}" alt="{{ $alt }}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A]/80 via-[#0F172A]/40 to-transparent"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] to-indigo-700"></div>
    @endif

    @if($title)
        <div class="relative h-full flex flex-col justify-center px-6 sm:px-8">
            <h2 class="text-lg sm:text-xl font-bold text-white">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-sm text-white/80 mt-1 max-w-md">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
</div>
