<?php

namespace App\Policies;

use App\Models\InternshipPeriod;
use App\Models\User;

class InternshipPeriodPolicy
{
    /**
     * Periode magang dikelola sepenuhnya oleh Admin. Mentor & mahasiswa
     * hanya dapat melihat (read-only) periode yang relevan bagi mereka
     * melalui halaman lain (dashboard, detail internship, dsb).
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, InternshipPeriod $internshipPeriod): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, InternshipPeriod $internshipPeriod): bool
    {
        return $user->isAdmin() && $internshipPeriod->internships()->doesntExist();
    }
}
