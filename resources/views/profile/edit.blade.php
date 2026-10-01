@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
    <p class="text-slate-500 mt-1">Kelola informasi akun dan keamanan Anda.</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <x-card title="Informasi Profil">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PUT')

                <div class="flex items-center gap-4">
                    @if($user->photo_path)
                        <img src="{{ $user->photoUrl() }}" alt="Foto profil {{ $user->name }}" class="w-16 h-16 rounded-full object-cover border border-slate-200">
                    @else
                        <x-avatar-initials :name="$user->name" size="w-16 h-16" textSize="text-lg" />
                    @endif
                    <div>
                        <label for="photo" class="btn btn-secondary cursor-pointer">
                            <i data-lucide="image" class="w-4 h-4"></i> Ganti Foto
                        </label>
                        <input type="file" name="photo" id="photo" class="hidden" onchange="previewFileName(this, 'photo-name')" accept="image/png,image/jpeg,image/jpg">
                        <p id="photo-name" class="hidden mt-1.5 text-xs text-slate-500"></p>
                        @error('photo')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <x-input name="name" label="Nama Lengkap" :value="$user->name" required />
                <x-input type="email" name="email" label="Email" :value="$user->email" required />
                <x-input name="phone" label="Nomor HP" :value="$user->phone" placeholder="08xxxxxxxxxx" />

                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </form>
        </x-card>

        <x-card title="Ubah Password">
            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf @method('PUT')
                <x-input type="password" name="current_password" label="Password Saat Ini" required toggle />
                <x-input type="password" name="password" label="Password Baru" required toggle />
                <x-input type="password" name="password_confirmation" label="Konfirmasi Password Baru" required toggle />
                <button type="submit" class="btn btn-secondary">
                    <i data-lucide="lock" class="w-4 h-4"></i> Ubah Password
                </button>
            </form>
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card title="Info Akun">
            <dl class="space-y-3 text-sm">
                <div><dt class="text-slate-400 mb-1">Role</dt><dd class="text-slate-700 font-medium capitalize">{{ $user->role }}</dd></div>
                <div><dt class="text-slate-400 mb-1">Status Akun</dt><dd><x-badge :status="$user->is_active ? 'active' : 'rejected'">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></dd></div>
                <div><dt class="text-slate-400 mb-1">Bergabung Sejak</dt><dd class="text-slate-700 font-medium">{{ $user->created_at->translatedFormat('d M Y') }}</dd></div>
            </dl>
            <p class="text-xs text-slate-400 mt-4">Akun Anda dibuat oleh administrator. Anda tetap dapat mengedit informasi profil dan password sendiri di halaman ini.</p>
        </x-card>
    </div>
</div>
@endsection
