<?php

namespace App\Policies;

use App\Models\Permit;
use App\Models\User;

class PermitPolicy
{
    /**
     * Mahasiswa hanya dapat melihat izin miliknya sendiri.
     * Mentor hanya dapat melihat izin mahasiswa yang menjadi bimbingannya.
     * Admin dapat melihat semua.
     */
    public function view(User $user, Permit $permit): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $permit->internship->user_id === $user->id
            || $permit->internship->mentor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isMahasiswa() && $user->internship !== null;
    }

    /**
     * Mahasiswa hanya dapat membatalkan/mengubah pengajuan miliknya
     * sendiri selama masih berstatus menunggu (pending).
     */
    public function update(User $user, Permit $permit): bool
    {
        return $user->isMahasiswa()
            && $permit->internship->user_id === $user->id
            && $permit->status === 'pending';
    }

    /**
     * Mentor hanya dapat memproses (approve/reject) pengajuan izin
     * mahasiswa yang memang berada di bawah bimbingannya, dan hanya
     * selama pengajuan masih berstatus menunggu.
     */
    public function review(User $user, Permit $permit): bool
    {
        return $user->isMentor()
            && $permit->internship->mentor_id === $user->id
            && $permit->status === 'pending';
    }
}
