{{--
    Avatar berbasis inisial nama (bukan foto), dipakai untuk profil mahasiswa/mentor
    karena foto pada folder public/foto adalah foto suasana/brand, bukan foto profil.
--}}
@props(['name', 'size' => 'w-11 h-11', 'textSize' => 'text-sm'])
@php
$initials = collect(explode(' ', trim($name)))
    ->filter()
    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
    ->take(2)
    ->implode('');
@endphp
<div {{ $attributes->merge(['class' => "$size rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold $textSize shrink-0"]) }}>
    {{ $initials ?: '?' }}
</div>
