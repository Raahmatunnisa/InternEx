<?php

use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\User;

function reportInternship(): Internship
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

test('laporan akhir dapat disubmit setelah judul dan file lengkap', function () {
    $internship = reportInternship();

    $report = FinalReport::factory()->for($internship)->create([
        'status' => 'draft',
        'title' => 'Laporan Akhir Magang',
        'file_path' => 'reports/dummy.pdf',
    ]);

    $this->actingAs($internship->student)
        ->post(route('final-report.submit', $report))
        ->assertRedirect(route('final-report.show'));

    expect($report->fresh()->status)->toBe('submitted');
});

test('mahasiswa lain tidak dapat mengakses laporan akhir orang lain', function () {
    $internshipA = reportInternship();
    $internshipB = reportInternship();

    $reportB = FinalReport::factory()->for($internshipB)->create();

    $this->actingAs($internshipA->student)
        ->put(route('final-report.update', $reportB), [
            'title' => 'Percobaan mengubah',
            'abstract' => 'Percobaan mengubah laporan orang lain.',
        ])
        ->assertForbidden();
});

test('mentor yang bukan pembimbing tidak dapat mereview laporan akhir', function () {
    $internship = reportInternship();
    $otherMentor = User::factory()->mentor()->create();

    $report = FinalReport::factory()->for($internship)->create(['status' => 'submitted']);

    $this->actingAs($otherMentor)
        ->post(route('final-reports.approve', $report))
        ->assertForbidden();
});
