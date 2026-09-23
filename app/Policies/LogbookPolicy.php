<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;

class LogbookPolicy
{
    public function view(User $user, Logbook $logbook): bool
    {
        return $logbook->internship->user_id === $user->id
            || $logbook->internship->mentor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isMahasiswa() && $user->internship !== null;
    }

    public function update(User $user, Logbook $logbook): bool
    {
        return $user->isMahasiswa()
            && $logbook->internship->user_id === $user->id
            && $logbook->status !== 'approved';
    }

    public function delete(User $user, Logbook $logbook): bool
    {
        return $user->isMahasiswa()
            && $logbook->internship->user_id === $user->id
            && $logbook->status !== 'approved';
    }

    /**
     * Mentor dapat mereview (approve/reject) logbook mahasiswa binaannya.
     */
    public function review(User $user, Logbook $logbook): bool
    {
        return $user->isMentor() && $logbook->internship->mentor_id === $user->id;
    }
}
