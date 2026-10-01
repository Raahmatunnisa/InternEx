{{--
    PhotoCarousel: hero visual panel untuk halaman login.
    Menampilkan slide foto dari App\Support\Photos::loginSlides() dengan
    transisi opacity halus, dot indicator, dan navigasi chevron.
    Implementasi JavaScript vanilla sederhana (lihat resources/js/app.js,
    fungsi initPhotoCarousels), tanpa dependency tambahan seperti Alpine/Swiper.
    Fallback: jika JS gagal dimuat, slide pertama tetap terlihat penuh (opacity-100)
    karena diset melalui class HTML statis, bukan lewat JavaScript.
--}}
@props([
    'title' => 'Selamat Datang',
    'subtitle' => null,
    'interval' => 5000,
])
@php
$slideContexts = \App\Support\Photos::loginSlides();
@endphp

@if(empty($slideContexts))
    {{-- Fallback: belum ada foto tersedia di public/foto --}}
    <div {{ $attributes->merge(['class' => 'relative w-full h-full min-h-[280px] rounded-2xl overflow-hidden bg-gradient-to-br from-[#0F172A] via-indigo-900 to-indigo-700 flex flex-col items-center justify-center text-center p-8']) }}>
        <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-5">
            <i data-lucide="clipboard-check" class="w-8 h-8 text-white"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2">{{ $title }}</h2>
        @if($subtitle)
            <p class="text-white/70 max-w-sm">{{ $subtitle }}</p>
        @endif
    </div>
@else
    <div
        {{ $attributes->merge(['class' => 'relative w-full h-full min-h-[280px] rounded-2xl overflow-hidden']) }}
        data-carousel
        data-interval="{{ $interval }}"
    >
        <div data-carousel-slides class="absolute inset-0">
            @foreach($slideContexts as $i => $context)
                <img
                    src="{{ \App\Support\Photos::url($context) }}"
                    alt="Suasana kegiatan magang {{ $i + 1 }}"
                    data-carousel-slide
                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                    @if($i === 0) fetchpriority="high" loading="eager" @else loading="lazy" @endif
                >
            @endforeach
        </div>

        {{-- Overlay gradient agar teks tetap terbaca --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/85 via-[#0F172A]/20 to-[#0F172A]/10"></div>

        {{-- Copywriting --}}
        <div class="relative h-full flex flex-col justify-end p-8">
            <h2 class="text-2xl font-bold text-white mb-2">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-white/80 max-w-sm mb-6">{{ $subtitle }}</p>
            @endif

            {{-- Dot indicator --}}
            <div class="flex items-center gap-2" data-carousel-dots role="tablist" aria-label="Navigasi slide">
                @foreach($slideContexts as $i => $context)
                    <button
                        type="button"
                        role="tab"
                        data-carousel-dot="{{ $i }}"
                        aria-label="Ke slide {{ $i + 1 }}"
                        class="h-1.5 rounded-full transition-all duration-300 {{ $i === 0 ? 'w-6 bg-white' : 'w-1.5 bg-white/40 hover:bg-white/60' }}"
                    ></button>
                @endforeach
            </div>
        </div>

        {{-- Navigasi chevron --}}
        <button
            type="button"
            data-carousel-prev
            aria-label="Slide sebelumnya"
            class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur flex items-center justify-center text-white transition focus:outline-none focus:ring-2 focus:ring-white/60"
        >
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>
        <button
            type="button"
            data-carousel-next
            aria-label="Slide berikutnya"
            class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur flex items-center justify-center text-white transition focus:outline-none focus:ring-2 focus:ring-white/60"
        >
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>
    </div>
@endif
