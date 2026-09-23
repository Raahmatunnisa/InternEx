{{--
    PhotoHero: panel visual besar (mis. sisi kanan hero dashboard/absensi).
    Props:
      context   : key pemetaan foto (lihat App\Support\Photos)
      alt       : alt text deskriptif (wajib diisi kecuali benar-benar dekoratif)
      overlay   : true untuk overlay gradient gelap tipis (default true)
      priority  : true untuk fetchpriority="high" + eager load (hero utama)
      fallbackIcon : nama icon lucide untuk fallback jika foto belum tersedia
--}}
@props([
    'context',
    'alt' => 'Ilustrasi kegiatan magang',
    'overlay' => true,
    'priority' => false,
    'fallbackIcon' => 'image',
])
@php
$url = \App\Support\Photos::url($context);
@endphp
<div {{ $attributes->merge(['class' => 'relative w-full h-full min-h-[180px] rounded-2xl overflow-hidden']) }}>
    @if($url)
        <img
            src="{{ $url }}"
            alt="{{ $alt }}"
            class="absolute inset-0 w-full h-full object-cover"
            @if($priority) fetchpriority="high" loading="eager" @else loading="lazy" @endif
        >
        @if($overlay)
            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/70 via-[#0F172A]/10 to-transparent"></div>
        @endif
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-[#0F172A] flex items-center justify-center">
            <i data-lucide="{{ $fallbackIcon }}" class="w-10 h-10 text-white/40"></i>
        </div>
    @endif

    @isset($slot)
        <div class="relative h-full flex flex-col justify-end p-6">
            {{ $slot }}
        </div>
    @endisset
</div>
