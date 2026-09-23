<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;

class InternshipPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isMentor();
    }

    public function view(User $user, Internship $internship): bool
    {
        return $user->isAdmin()
            || $internship->user_id === $user->id
            || $internship->mentor_id === $user->id;
    }

    /**
     * Hanya Admin yang dapat membuat/mengubah data penempatan magang
     * (mentor pembimbing, periode, bagian, ruangan) milik mahasiswa.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Internship $internship): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Internship $internship): bool
    {
        return $user->isAdmin();
    }

    /**
     * Hanya mentor pembimbing mahasiswa yang bersangkutan yang dapat
     * memberi/mengubah nilai (lihat Mentor\AssessmentController).
     */
    public function assess(User $user, Internship $internship): bool
    {
        return $user->isMentor() && $internship->mentor_id === $user->id;
    }
}
