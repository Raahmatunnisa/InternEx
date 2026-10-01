<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - InternX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
</head>
<body class="min-h-screen bg-[#F8FAFC]">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        {{-- Kolom kiri: branding + form login --}}
        <div class="flex flex-col justify-center px-6 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-md mx-auto">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-900 leading-none">InternX</p>
                        <p class="text-xs text-slate-400 mt-1">Kontribusi. Berkembang. Berdampak.</p>
                    </div>
                </div>

                {{-- Hero visual dipindah ke atas form khusus tampilan mobile --}}
                <div class="lg:hidden h-48 mb-8 rounded-2xl overflow-hidden">
                    <x-photo-carousel
                        title="Selamat Datang di InternX"
                        subtitle="Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur."
                        class="h-full"
                    />
                </div>

                <h1 class="text-xl font-bold text-slate-900 mb-1">Selamat Datang Kembali</h1>
                <p class="text-sm text-slate-500 mb-6">Masuk ke workspace InternX untuk melanjutkan aktivitas magangmu.</p>

                @if ($errors->any())
                    <div class="mb-5">
                        <x-alert type="error">
                            <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
                            <span>{{ $errors->first() }}</span>
                        </x-alert>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf
                    <x-input label="Email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="nama@kampus.ac.id" />
                    <x-input label="Password" name="password" type="password" required placeholder="Masukkan password" toggle />

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            Ingat saya
                        </label>
                    </div>

                    <x-button type="submit" class="w-full">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Workspace
                    </x-button>
                </form>

                <p class="text-xs text-center text-slate-400 mt-6">
                    Akun dibuat oleh administrator/mentor. Hubungi mentor Anda jika belum memiliki akun.
                </p>

                <div class="grid grid-cols-3 gap-3 mt-10 pt-6 border-t border-slate-200">
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-indigo-600"></i>
                        <p class="text-xs font-medium text-slate-600">Aktivitas Harian</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="calendar-check" class="w-5 h-5 text-emerald-600"></i>
                        <p class="text-xs font-medium text-slate-600">Kehadiran</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        <p class="text-xs font-medium text-slate-600">Laporan Akhir</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: hero visual panel dengan photo carousel (desktop) --}}
        <div class="hidden lg:block relative p-6">
            <x-photo-carousel
                title="Selamat Datang di InternX"
                subtitle="Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur."
                class="h-full"
            />
        </div>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
