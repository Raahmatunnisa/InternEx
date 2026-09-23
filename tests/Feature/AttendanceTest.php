<?php

use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;

function attendanceInternship(): Internship
{
    $student = User::factory()->mahasiswa()->create();
    $mentor = User::factory()->mentor()->create();
    $period = InternshipPeriod::factory()->create();

    return Internship::factory()->create([
        'user_id' => $student->id,
        'mentor_id' => $mentor->id,
        'internship_period_id' => $period->id,
    ]);
}

test('mahasiswa dapat melakukan check-in', function () {
    $internship = attendanceInternship();

    $this->actingAs($internship->student)
        ->post(route('attendances.checkIn'))
        ->assertRedirect();

    $this->assertDatabaseHas('attendances', [
        'internship_id' => $internship->id,
        'date' => now()->format('Y-m-d'),
    ]);
});

test('mahasiswa tidak dapat check-in dua kali pada tanggal yang sama', function () {
    $internship = attendanceInternship();

    $this->actingAs($internship->student)->post(route('attendances.checkIn'));
    $response = $this->actingAs($internship->student)->post(route('attendances.checkIn'));

    $response->assertSessionHas('error');
    expect($internship->attendances()->whereDate('date', today())->count())->toBe(1);
});

test('mahasiswa dapat check-out setelah check-in', function () {
    $internship = attendanceInternship();

    $this->actingAs($internship->student)->post(route('attendances.checkIn'));
    $this->actingAs($internship->student)->post(route('attendances.checkOut'));

    $attendance = $internship->attendances()->whereDate('date', today())->first();

    expect($attendance->check_out_time)->not->toBeNull();
});

test('mahasiswa tidak dapat check-out sebelum check-in', function () {
    $internship = attendanceInternship();

    $response = $this->actingAs($internship->student)->post(route('attendances.checkOut'));

    $response->assertSessionHas('error');
});
