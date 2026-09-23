<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Models\Attendance;
use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\InternshipPeriod;
use App\Models\Logbook;
use App\Models\Permit;
use App\Policies\AssessmentPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\FinalReportPolicy;
use App\Policies\InternshipPeriodPolicy;
use App\Policies\InternshipPolicy;
use App\Policies\LogbookPolicy;
use App\Policies\PermitPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Internship::class, InternshipPolicy::class);
        Gate::policy(Logbook::class, LogbookPolicy::class);
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(FinalReport::class, FinalReportPolicy::class);
        Gate::policy(InternshipPeriod::class, InternshipPeriodPolicy::class);
        Gate::policy(Permit::class, PermitPolicy::class);
        Gate::policy(Assessment::class, AssessmentPolicy::class);
    }
}
