<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Division;
use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\Logbook;
use App\Models\LogbookFeedback;
use App\Models\Permit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder ini membuat data demo InternEX yang realistis untuk development.
     * PENTING: password di bawah ini hanya untuk keperluan development/testing,
     * jangan pernah digunakan pada environment production.
     */
    public function run(): void
    {
        // Akun demo admin
        $demoAdmin = User::create([
            'name' => 'Admin InternX',
            'email' => 'admin@internex.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Akun demo utama (disebutkan di README)
        $demoMentor = User::create([
            'name' => 'Budi Santoso',
            'email' => 'mentor@internex.test',
            'password' => Hash::make('password'),
            'role' => 'mentor',
            'is_active' => true,
        ]);

        $demoStudent = User::create([
            'name' => 'Yulli Andriani',
            'email' => 'mahasiswa@internex.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'is_active' => true,
        ]);

        // Mentor & periode tambahan
        $mentors = collect([$demoMentor])->concat(User::factory()->mentor()->count(1)->create());

        $activePeriod = InternshipPeriod::create([
            'name' => 'Magang Genap 2026',
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonths(2),
            'description' => 'Periode magang semester genap tahun akademik 2025/2026.',
            'status' => 'active',
        ]);

        $completedPeriod = InternshipPeriod::create([
            'name' => 'Magang Ganjil 2025',
            'start_date' => now()->subMonths(8),
            'end_date' => now()->subMonths(4),
            'description' => 'Periode magang semester ganjil tahun akademik 2025/2026.',
            'status' => 'completed',
        ]);

        // Bagian/divisi (dikelola oleh Admin)
        $divisions = collect([
            Division::create(['name' => 'Software Engineering', 'description' => 'Divisi pengembangan perangkat lunak.']),
            Division::create(['name' => 'Data & Analytics', 'description' => 'Divisi analisis data dan pelaporan.']),
            Division::create(['name' => 'UI/UX Design', 'description' => 'Divisi riset dan desain antarmuka.']),
        ]);

        // Internship demo student -> demo mentor
        $demoInternship = Internship::create([
            'user_id' => $demoStudent->id,
            'mentor_id' => $demoMentor->id,
            'internship_period_id' => $activePeriod->id,
            'division_id' => $divisions[0]->id,
            'institution' => 'PT Teknologi Nusantara',
            'program' => 'Software Engineering',
            'start_date' => $activePeriod->start_date,
            'end_date' => $activePeriod->end_date,
            'status' => 'active',
        ]);

        $this->seedActivitiesFor($demoInternship, $demoMentor, deterministicReportStatus: 'draft');
        $this->seedPermitsFor($demoInternship, $demoMentor);

        // 4 mahasiswa tambahan tersebar di 2 mentor & 2 periode
        $students = User::factory()->mahasiswa()->count(4)->create();

        foreach ($students as $index => $student) {
            $mentor = $mentors[$index % $mentors->count()];
            $period = $index % 2 === 0 ? $activePeriod : $completedPeriod;

            $internship = Internship::create([
                'user_id' => $student->id,
                'mentor_id' => $mentor->id,
                'internship_period_id' => $period->id,
                'division_id' => $divisions[$index % $divisions->count()]->id,
                'institution' => fake()->company(),
                'program' => fake()->randomElement(['Software Engineering', 'Data Analyst', 'UI/UX Design', 'Digital Marketing']),
                'start_date' => $period->start_date,
                'end_date' => $period->end_date,
                'status' => $period->status === 'completed' ? 'completed' : 'active',
            ]);

            $this->seedActivitiesFor($internship, $mentor);

            if ($index === 1) {
                $this->seedPermitsFor($internship, $mentor);
            }
        }

        $this->command?->info('Akun demo dibuat:');
        $this->command?->info('  Admin    : admin@internex.test / password');
        $this->command?->info('  Mentor   : mentor@internex.test / password');
        $this->command?->info('  Mahasiswa: mahasiswa@internex.test / password');
    }

    protected function seedActivitiesFor(Internship $internship, User $mentor, ?string $deterministicReportStatus = null): void
    {
        // Logbook dengan berbagai status
        $logbooks = Logbook::factory()->count(8)->for($internship)->create();

        foreach ($logbooks as $logbook) {
            if (in_array($logbook->status, ['approved', 'rejected'])) {
                LogbookFeedback::factory()->for($logbook)->create(['mentor_id' => $mentor->id]);
            }
        }

        // Attendance beberapa hari terakhir
        for ($i = 10; $i >= 0; $i--) {
            $date = now()->subDays($i);

            if ($date->isWeekend()) {
                continue;
            }

            Attendance::factory()->for($internship)->create([
                'date' => $date->format('Y-m-d'),
            ]);
        }

        // Final report dengan status acak (atau deterministik untuk akun demo utama
        // agar mudah didemokan tanpa bergantung pada hasil random seeder).
        $status = $deterministicReportStatus ?? fake()->randomElement(['draft', 'submitted', 'reviewed', 'approved', 'revision']);

        $finalReport = FinalReport::factory()->for($internship)->create([
            'status' => $status,
            'title' => $status === 'draft' ? null : 'Laporan Akhir Magang - '.$internship->program,
            'abstract' => $status === 'draft' ? null : fake()->paragraph(5),
        ]);

        if (in_array($status, ['reviewed', 'approved', 'revision'])) {
            $finalReport->feedbacks()->create([
                'mentor_id' => $mentor->id,
                'feedback' => $status === 'revision'
                    ? 'Mohon perbaiki bagian metodologi dan lampirkan data pendukung.'
                    : 'Laporan sudah cukup baik, lanjutkan ke tahap berikutnya.',
            ]);
        }
    }

    protected function seedPermitsFor(Internship $internship, User $mentor): void
    {
        Permit::create([
            'internship_id' => $internship->id,
            'type' => 'sakit',
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(4),
            'reason' => 'Demam dan perlu istirahat sesuai anjuran dokter.',
            'status' => 'approved',
            'review_note' => 'Semoga lekas sembuh.',
            'reviewed_by' => $mentor->id,
            'reviewed_at' => now()->subDays(4),
        ]);

        Permit::create([
            'internship_id' => $internship->id,
            'type' => 'izin',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(2),
            'reason' => 'Mengurus keperluan administrasi kampus.',
            'status' => 'pending',
        ]);
    }
}
