<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function view(User $user, Attendance $attendance): bool
    {
        return $attendance->internship->user_id === $user->id
            || $attendance->internship->mentor_id === $user->id;
    }

    /**
     * Hanya mentor pembimbing mahasiswa yang bersangkutan yang boleh
     * mengubah status/jam kehadiran (mis. menandai izin/sakit/alpha).
     */
    public function update(User $user, Attendance $attendance): bool
    {
        return $attendance->internship->mentor_id === $user->id;
    }

    /**
     * Hanya mentor pembimbing yang boleh menghapus data kehadiran yang
     * keliru (mis. mahasiswa absen padahal hari itu libur).
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $attendance->internship->mentor_id === $user->id;
    }
}
