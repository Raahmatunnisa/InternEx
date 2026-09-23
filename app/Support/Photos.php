<?php

namespace App\Support;

/**
 * Helper terpusat untuk memetakan foto brand aplikasi (folder public/foto)
 * ke konteks/section tertentu, sehingga path foto tidak di-hardcode
 * berulang kali di banyak file Blade.
 *
 * Cara pakai di project Anda:
 *  1. Salin foto Anda (foto1.png, foto2.png, dst) ke folder `public/foto/`.
 *  2. Panggil dari Blade: <x-photo-hero :context="'dashboard.mahasiswa.hero'" ... />
 *
 * Jika file foto untuk sebuah context belum tersedia, komponen visual
 * (PhotoHero/PhotoBanner/PhotoCard/PhotoCarousel) akan otomatis
 * menampilkan fallback netral berbasis icon, bukan gambar rusak.
 */
class Photos
{
    /**
     * Peta context -> nama file di public/foto.
     * Setiap section utama sengaja diberi foto berbeda agar aplikasi
     * terasa dinamis (prinsip "one strong visual per major section").
     */
    protected static array $map = [
        'login.slide.1' => 'foto1.png',
        'login.slide.2' => 'foto2.png',
        'login.slide.3' => 'foto3.png',

        'dashboard.mahasiswa.hero' => 'foto4.png',
        'dashboard.mentor.hero' => 'foto8.png',

        'logbook.banner' => 'foto5.png',
        'logbook.create.side' => 'foto2.png',

        'attendance.hero' => 'foto6.png',

        'final-report.banner' => 'foto7.png',

        'students.banner' => 'foto3.png',
        'periods.banner' => 'foto1.png',
        'logbook-reviews.banner' => 'foto5.png',
        'attendance-monitoring.banner' => 'foto6.png',
    ];

    /**
     * Ambil nama file foto untuk sebuah context.
     */
    public static function file(string $context): ?string
    {
        return static::$map[$context] ?? null;
    }

    /**
     * Apakah file foto untuk context ini benar-benar ada di public/foto.
     */
    public static function exists(string $context): bool
    {
        $file = static::file($context);

        return $file && file_exists(public_path('foto/'.$file));
    }

    /**
     * URL publik foto untuk context tertentu, atau null jika tidak tersedia.
     */
    public static function url(string $context): ?string
    {
        return static::exists($context) ? asset('foto/'.static::file($context)) : null;
    }

    /**
     * Daftar context untuk slide carousel login, hanya yang filenya tersedia.
     * Jika belum ada foto sama sekali, kembalikan array kosong agar carousel
     * otomatis menampilkan fallback branding tanpa foto.
     */
    public static function loginSlides(): array
    {
        return collect(['login.slide.1', 'login.slide.2', 'login.slide.3'])
            ->filter(fn ($context) => static::exists($context))
            ->values()
            ->all();
    }
}
