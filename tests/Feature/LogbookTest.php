<?php

use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\Logbook;
use App\Models\User;

function makeInternship(?User $student = null, ?User $mentor = null): Internship
{
    $student ??= User::factory()->mahasiswa()->create();
    $mentor ??= User::factory()->mentor()->create();
    $period = InternshipPeriod::factory()->create();

    return Internship::factory()->create([
        'user_id' => $student->id,
        'mentor_id' => $mentor->id,
        'internship_period_id' => $period->id,
    ]);
}

test('mahasiswa hanya dapat melihat logbook miliknya sendiri', function () {
    $internshipA = makeInternship();
    $internshipB = makeInternship();

    $logbookB = Logbook::factory()->for($internshipB)->create();

    $this->actingAs($internshipA->student)
        ->get(route('logbooks.show', $logbookB))
        ->assertForbidden();
});

test('mahasiswa dapat membuat logbook dengan data valid', function () {
    $internship = makeInternship();

    $response = $this->actingAs($internship->student)->post(route('logbooks.store'), [
        'date' => now()->format('Y-m-d'),
        'start_time' => '08:00',
        'end_time' => '16:00',
        'activity' => 'Mengerjakan fitur baru',
        'description' => 'Implementasi fitur autentikasi pada aplikasi.',
    ]);

    $response->assertRedirect(route('logbooks.index'));
    $this->assertDatabaseHas('logbooks', [
        'internship_id' => $internship->id,
        'activity' => 'Mengerjakan fitur baru',
        'status' => 'submitted',
    ]);
});

test('mahasiswa tidak dapat mengubah logbook milik mahasiswa lain', function () {
    $internshipA = makeInternship();
    $internshipB = makeInternship();

    $logbookB = Logbook::factory()->for($internshipB)->create(['status' => 'submitted']);

    $this->actingAs($internshipA->student)
        ->put(route('logbooks.update', $logbookB), [
            'date' => now()->format('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '16:00',
            'activity' => 'Ubah paksa',
            'description' => 'Percobaan mengubah logbook orang lain.',
        ])
        ->assertForbidden();
});

test('mentor dapat approve logbook mahasiswa binaannya', function () {
    $internship = makeInternship();
    $logbook = Logbook::factory()->for($internship)->create(['status' => 'submitted']);

    $this->actingAs($internship->mentor)
        ->post(route('logbook-reviews.approve', $logbook))
        ->assertRedirect(route('logbook-reviews.index'));

    expect($logbook->fresh()->status)->toBe('approved');
});

test('mentor dapat reject logbook dengan feedback wajib', function () {
    $internship = makeInternship();
    $logbook = Logbook::factory()->for($internship)->create(['status' => 'submitted']);

    $response = $this->actingAs($internship->mentor)
        ->post(route('logbook-reviews.reject', $logbook), []);

    $response->assertSessionHasErrors('feedback');
    expect($logbook->fresh()->status)->toBe('submitted');
});

test('mentor tidak dapat mereview logbook mahasiswa yang bukan binaannya', function () {
    $internshipA = makeInternship();
    $otherMentor = User::factory()->mentor()->create();

    $logbookA = Logbook::factory()->for($internshipA)->create(['status' => 'submitted']);

    $this->actingAs($otherMentor)
        ->post(route('logbook-reviews.approve', $logbookA))
        ->assertForbidden();
});
