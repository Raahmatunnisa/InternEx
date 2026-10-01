<?php

namespace App\Policies;

use App\Models\FinalReport;
use App\Models\User;

class FinalReportPolicy
{
    public function view(User $user, FinalReport $finalReport): bool
    {
        return $user->isAdmin()
            || $finalReport->internship->user_id === $user->id
            || $finalReport->internship->mentor_id === $user->id;
    }

    public function update(User $user, FinalReport $finalReport): bool
    {
        return $user->isMahasiswa()
            && $finalReport->internship->user_id === $user->id
            && in_array($finalReport->status, ['draft', 'revision'], true);
    }

    public function submit(User $user, FinalReport $finalReport): bool
    {
        return $user->isMahasiswa()
            && $finalReport->internship->user_id === $user->id
            && in_array($finalReport->status, ['draft', 'revision'], true)
            && filled($finalReport->title)
            && filled($finalReport->file_path);
    }

    /**
     * Mentor dapat mereview laporan akhir mahasiswa binaannya.
     */
    public function review(User $user, FinalReport $finalReport): bool
    {
        return $user->isMentor() && $finalReport->internship->mentor_id === $user->id;
    }
}
