<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;

class AssessmentPolicy
{
    /**
     * Admin dapat melihat seluruh penilaian, mahasiswa hanya penilaian
     * miliknya sendiri, dan mentor hanya penilaian mahasiswa bimbingannya.
     */
    public function view(User $user, Assessment $assessment): bool
    {
        return $user->isAdmin()
            || $assessment->internship->user_id === $user->id
            || $assessment->internship->mentor_id === $user->id;
    }
}
