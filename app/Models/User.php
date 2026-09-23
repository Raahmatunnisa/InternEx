<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'photo_path',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function photoUrl(): ?string
    {
        return $this->photo_path
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo_path)
            : null;
    }

    /**
     * Data magang milik mahasiswa ini (jika role mahasiswa).
     */
    public function internship(): HasOne
    {
        return $this->hasOne(Internship::class, 'user_id');
    }

    /**
     * Daftar mahasiswa binaan (jika role mentor).
     */
    public function studentInternships(): HasMany
    {
        return $this->hasMany(Internship::class, 'mentor_id');
    }

    public function logbookFeedbacks(): HasMany
    {
        return $this->hasMany(LogbookFeedback::class, 'mentor_id');
    }

    public function finalReportFeedbacks(): HasMany
    {
        return $this->hasMany(FinalReportFeedback::class, 'mentor_id');
    }

    /**
     * Pengajuan izin yang sudah direview oleh user ini (jika role mentor).
     */
    public function reviewedPermits(): HasMany
    {
        return $this->hasMany(Permit::class, 'reviewed_by');
    }
}
