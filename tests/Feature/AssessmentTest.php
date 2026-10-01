<?php

use App\Models\Assessment;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;

function assessmentInternship(): Internship
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

test('mentor dapat memberi nilai baru kepada mahasiswa bimbingannya', function () {
    $internship = assessmentInternship();

    $this->actingAs($internship->mentor)
        ->post(route('assessments.store', $internship), [
            'attendance_score' => 90,
            'logbook_score' => 80,
            'final_report_score' => 85,
            'presentation_score' => 70,
        ])
        ->assertRedirect(route('students.show', $internship));

    $assessment = $internship->fresh()->assessment;

    expect($assessment)->not->toBeNull();
    // (90*0.10)+(80*0.20)+(85*0.50)+(70*0.20) = 9+16+42.5+14 = 81.5
    expect((float) $assessment->final_score)->toBe(81.5);
    expect($assessment->grade)->toBe('AB');
    expect((float) $assessment->grade_point)->toBe(3.5);
});

test('mentor dapat mengubah nilai yang sudah ada (upsert, bukan duplikat)', function () {
    $internship = assessmentInternship();

    Assessment::factory()->for($internship)->for($internship->mentor, 'mentor')->create();

    $this->actingAs($internship->mentor)
        ->post(route('assessments.store', $internship), [
            'attendance_score' => 100,
            'logbook_score' => 100,
            'final_report_score' => 100,
            'presentation_score' => 100,
        ]);

    expect(Assessment::where('internship_id', $internship->id)->count())->toBe(1);

    $assessment = $internship->fresh()->assessment;
    expect((float) $assessment->final_score)->toBe(100.0);
    expect($assessment->grade)->toBe('A');
});

test('mentor tidak dapat menilai mahasiswa yang bukan bimbingannya', function () {
    $internship = assessmentInternship();
    $otherMentor = User::factory()->mentor()->create();

    $this->actingAs($otherMentor)
        ->post(route('assessments.store', $internship), [
            'attendance_score' => 80,
            'logbook_score' => 80,
            'final_report_score' => 80,
            'presentation_score' => 80,
        ])
        ->assertForbidden();

    expect($internship->fresh()->assessment)->toBeNull();
});

test('mahasiswa hanya dapat melihat nilainya sendiri', function () {
    $internshipA = assessmentInternship();
    $internshipB = assessmentInternship();

    Assessment::factory()->for($internshipB)->for($internshipB->mentor, 'mentor')->create();

    $response = $this->actingAs($internshipA->student)->get(route('assessment.show'));

    $response->assertOk();
    $response->assertSee('Penilaian belum tersedia');
});

test('mahasiswa melihat nilainya sendiri ketika sudah dinilai', function () {
    $internship = assessmentInternship();

    Assessment::factory()->for($internship)->for($internship->mentor, 'mentor')->create([
        'attendance_score' => 100,
        'logbook_score' => 100,
        'final_report_score' => 100,
        'presentation_score' => 100,
    ]);

    $response = $this->actingAs($internship->student)->get(route('assessment.show'));

    $response->assertOk();
    $response->assertDontSee('Penilaian belum tersedia');
    $response->assertSee('100.00');
});

test('admin dapat melihat seluruh data penilaian', function () {
    $internship = assessmentInternship();
    Assessment::factory()->for($internship)->for($internship->mentor, 'mentor')->create();

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.assessments.index'))
        ->assertOk()
        ->assertSee($internship->student->name);
});

test('boundary konversi nilai akhir ke grade dan grade point sudah tepat', function (float $score, string $grade, float $point) {
    expect(Assessment::resolveGrade($score))->toBe([$grade, $point]);
})->with([
    [87, 'A', 4.0],
    [100, 'A', 4.0],
    [86.99, 'AB', 3.5],
    [78, 'AB', 3.5],
    [77.99, 'B', 3.0],
    [69, 'B', 3.0],
    [68.99, 'BC', 2.5],
    [60, 'BC', 2.5],
    [59.99, 'C', 2.0],
    [51, 'C', 2.0],
    [50.99, 'D', 1.0],
    [41, 'D', 1.0],
    [40.99, 'E', 0.0],
    [0, 'E', 0.0],
]);
