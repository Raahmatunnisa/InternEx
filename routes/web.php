<?php

use App\Http\Controllers\Admin\AssessmentController as AdminAssessmentController;
use App\Http\Controllers\Admin\AttendanceMonitoringController as AdminAttendanceMonitoringController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MentorController as AdminMentorController;
use App\Http\Controllers\Admin\PeriodController as AdminPeriodController;
use App\Http\Controllers\Admin\StudentMentorController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinalReportController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\Mentor\AssessmentController as MentorAssessmentController;
use App\Http\Controllers\Mentor\AttendanceMonitoringController;
use App\Http\Controllers\Mentor\FinalReportReviewController;
use App\Http\Controllers\Mentor\LogbookReviewController;
use App\Http\Controllers\Mentor\PermitController as MentorPermitController;
use App\Http\Controllers\Mentor\StudentController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil sendiri: tersedia untuk semua role yang login (mahasiswa, mentor, admin).
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Fitur mahasiswa
    Route::middleware('role:mahasiswa')->group(function () {
        Route::resource('logbooks', LogbookController::class)->except(['show'])->names('logbooks');
        Route::get('logbooks/{logbook}', [LogbookController::class, 'show'])->name('logbooks.show');

        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkIn');
        Route::post('attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkOut');

        Route::get('permits', [PermitController::class, 'index'])->name('permits.index');
        Route::get('permits/create', [PermitController::class, 'create'])->name('permits.create');
        Route::post('permits', [PermitController::class, 'store'])->name('permits.store');
        Route::get('permits/{permit}', [PermitController::class, 'show'])->name('permits.show');
        Route::get('permits/{permit}/attachment', [PermitController::class, 'attachment'])->name('permits.attachment');

        Route::get('final-report', [FinalReportController::class, 'show'])->name('final-report.show');
        Route::put('final-report/{final_report}', [FinalReportController::class, 'update'])->name('final-report.update');
        Route::post('final-report/{final_report}/submit', [FinalReportController::class, 'submit'])->name('final-report.submit');
        Route::get('final-report/{final_report}/preview', [FinalReportController::class, 'preview'])->name('final-report.preview');

        Route::get('nilai', [AssessmentController::class, 'show'])->name('assessment.show');
    });

    // Fitur mentor
    Route::middleware('role:mentor')->prefix('mentor')->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::post('students/{student}/assessment', [MentorAssessmentController::class, 'store'])->name('assessments.store');

        Route::get('logbook-reviews', [LogbookReviewController::class, 'index'])->name('logbook-reviews.index');
        Route::get('logbook-reviews/{logbook}', [LogbookReviewController::class, 'show'])->name('logbook-reviews.show');
        Route::post('logbook-reviews/{logbook}/approve', [LogbookReviewController::class, 'approve'])->name('logbook-reviews.approve');
        Route::post('logbook-reviews/{logbook}/reject', [LogbookReviewController::class, 'reject'])->name('logbook-reviews.reject');

        Route::get('attendance-monitoring', [AttendanceMonitoringController::class, 'index'])->name('attendance-monitoring.index');
        Route::get('attendance-monitoring/create', [AttendanceMonitoringController::class, 'create'])->name('attendance-monitoring.create');
        Route::post('attendance-monitoring', [AttendanceMonitoringController::class, 'store'])->name('attendance-monitoring.store');
        Route::get('attendance-monitoring/{attendance}/edit', [AttendanceMonitoringController::class, 'edit'])->name('attendance-monitoring.edit');
        Route::put('attendance-monitoring/{attendance}', [AttendanceMonitoringController::class, 'update'])->name('attendance-monitoring.update');
        Route::delete('attendance-monitoring/{attendance}', [AttendanceMonitoringController::class, 'destroy'])->name('attendance-monitoring.destroy');

        Route::get('permits', [MentorPermitController::class, 'index'])->name('permits-review.index');
        Route::get('permits/{permit}', [MentorPermitController::class, 'show'])->name('permits-review.show');
        Route::get('permits/{permit}/attachment', [MentorPermitController::class, 'attachment'])->name('permits-review.attachment');
        Route::post('permits/{permit}/approve', [MentorPermitController::class, 'approve'])->name('permits-review.approve');
        Route::post('permits/{permit}/reject', [MentorPermitController::class, 'reject'])->name('permits-review.reject');

        Route::get('final-reports', [FinalReportReviewController::class, 'index'])->name('final-reports.index');
        Route::get('final-reports/{final_report}', [FinalReportReviewController::class, 'show'])->name('final-reports.show');
        Route::get('final-reports/{final_report}/preview', [FinalReportReviewController::class, 'preview'])->name('final-reports.preview');
        Route::post('final-reports/{final_report}/review', [FinalReportReviewController::class, 'review'])->name('final-reports.review');
        Route::post('final-reports/{final_report}/approve', [FinalReportReviewController::class, 'approve'])->name('final-reports.approve');
        Route::post('final-reports/{final_report}/request-revision', [FinalReportReviewController::class, 'requestRevision'])->name('final-reports.request-revision');
    });

    // Fitur admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::post('mahasiswa/{mahasiswa}/toggle-active', [MahasiswaController::class, 'toggleActive'])->name('mahasiswa.toggle-active');
        Route::delete('mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

        Route::get('mentor', [AdminMentorController::class, 'index'])->name('mentor.index');
        Route::get('mentor/create', [AdminMentorController::class, 'create'])->name('mentor.create');
        Route::post('mentor', [AdminMentorController::class, 'store'])->name('mentor.store');
        Route::get('mentor/{mentor}/edit', [AdminMentorController::class, 'edit'])->name('mentor.edit');
        Route::put('mentor/{mentor}', [AdminMentorController::class, 'update'])->name('mentor.update');
        Route::post('mentor/{mentor}/toggle-active', [AdminMentorController::class, 'toggleActive'])->name('mentor.toggle-active');
        Route::delete('mentor/{mentor}', [AdminMentorController::class, 'destroy'])->name('mentor.destroy');

        Route::get('relasi', [StudentMentorController::class, 'index'])->name('relasi.index');
        Route::put('relasi/bulk-update', [StudentMentorController::class, 'bulkUpdate'])->name('relasi.bulk-update');
        Route::put('relasi/{internship}', [StudentMentorController::class, 'update'])->name('relasi.update');

        Route::resource('periods', AdminPeriodController::class)->except(['show'])->names('periods');

        Route::get('divisions', [DivisionController::class, 'index'])->name('divisions.index');
        Route::post('divisions', [DivisionController::class, 'store'])->name('divisions.store');
        Route::put('divisions/{division}', [DivisionController::class, 'update'])->name('divisions.update');
        Route::delete('divisions/{division}', [DivisionController::class, 'destroy'])->name('divisions.destroy');

        Route::get('penilaian', [AdminAssessmentController::class, 'index'])->name('assessments.index');
        Route::get('penilaian/{assessment}/dokumen', [AdminAssessmentController::class, 'document'])->name('assessments.document');

        Route::get('kehadiran', [AdminAttendanceMonitoringController::class, 'index'])->name('attendance-monitoring.index');
        Route::get('kehadiran/import', [AdminAttendanceMonitoringController::class, 'importForm'])->name('attendance-monitoring.import-form');
        Route::post('kehadiran/import', [AdminAttendanceMonitoringController::class, 'import'])->name('attendance-monitoring.import');
        Route::get('kehadiran/export', [AdminAttendanceMonitoringController::class, 'export'])->name('attendance-monitoring.export');
        Route::get('kehadiran/{internship}', [AdminAttendanceMonitoringController::class, 'detail'])->name('attendance-monitoring.detail');
    });
});
