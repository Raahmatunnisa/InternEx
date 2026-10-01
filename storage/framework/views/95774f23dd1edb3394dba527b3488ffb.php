<div class="flex flex-col h-full">
    <div class="flex items-center gap-3 px-5 py-6">
        <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center shrink-0">
            <i data-lucide="clipboard-check" class="w-5 h-5 text-white"></i>
        </div>
        <div>
            <p class="font-bold text-white leading-none">InternX</p>
            <p class="text-[11px] text-slate-400 mt-1">Kontribusi. Berkembang. Berdampak.</p>
        </div>
    </div>

    <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="<?php echo e(route('admin.mahasiswa.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.mahasiswa.*') ? 'active' : ''); ?>">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i> Mahasiswa
                </a>
                <a href="<?php echo e(route('admin.mentor.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.mentor.*') ? 'active' : ''); ?>">
                    <i data-lucide="user-check" class="w-5 h-5"></i> Mentor
                </a>
                <a href="<?php echo e(route('admin.relasi.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.relasi.*') ? 'active' : ''); ?>">
                    <i data-lucide="git-branch" class="w-5 h-5"></i> Relasi Mahasiswa-Mentor
                </a>
                <a href="<?php echo e(route('admin.periods.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.periods.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-range" class="w-5 h-5"></i> Periode Magang
                </a>
                <a href="<?php echo e(route('admin.divisions.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.divisions.*') ? 'active' : ''); ?>">
                    <i data-lucide="building-2" class="w-5 h-5"></i> Divisi/Tim Kerja
                </a>
                <a href="<?php echo e(route('admin.assessments.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.assessments.*') ? 'active' : ''); ?>">
                    <i data-lucide="award" class="w-5 h-5"></i> Penilaian
                </a>
                <a href="<?php echo e(route('admin.attendance-monitoring.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.attendance-monitoring.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-check" class="w-5 h-5"></i> Monitoring Kehadiran
                </a>
                <a href="<?php echo e(route('admin.performance-monitoring.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.performance-monitoring.*') ? 'active' : ''); ?>">
                    <i data-lucide="activity" class="w-5 h-5"></i> Monitoring Kinerja
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                    <i data-lucide="user-round" class="w-5 h-5"></i> Pengaturan Akun
                </a>
            <?php elseif(auth()->user()->isMahasiswa()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="<?php echo e(route('logbooks.index')); ?>" class="nav-link <?php echo e(request()->routeIs('logbooks.*') ? 'active' : ''); ?>">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i> Aktivitas Harian
                </a>
                <a href="<?php echo e(route('attendances.index')); ?>" class="nav-link <?php echo e(request()->routeIs('attendances.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-check" class="w-5 h-5"></i> Kehadiran
                </a>
                <a href="<?php echo e(route('permits.index')); ?>" class="nav-link <?php echo e(request()->routeIs('permits.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-off" class="w-5 h-5"></i> Pengajuan Izin
                </a>
                <a href="<?php echo e(route('final-report.show')); ?>" class="nav-link <?php echo e(request()->routeIs('final-report.*') ? 'active' : ''); ?>">
                    <i data-lucide="file-text" class="w-5 h-5"></i> Laporan Akhir
                </a>
                <a href="<?php echo e(route('assessment.show')); ?>" class="nav-link <?php echo e(request()->routeIs('assessment.*') ? 'active' : ''); ?>">
                    <i data-lucide="award" class="w-5 h-5"></i> Nilai
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                    <i data-lucide="user-round" class="w-5 h-5"></i> Profil
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="<?php echo e(route('students.index')); ?>" class="nav-link <?php echo e(request()->routeIs('students.*') ? 'active' : ''); ?>">
                    <i data-lucide="users" class="w-5 h-5"></i> Mahasiswa Bimbingan
                </a>
                <a href="<?php echo e(route('logbook-reviews.index')); ?>" class="nav-link <?php echo e(request()->routeIs('logbook-reviews.*') ? 'active' : ''); ?>">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i> Review Aktivitas
                </a>
                <a href="<?php echo e(route('attendance-monitoring.index')); ?>" class="nav-link <?php echo e(request()->routeIs('attendance-monitoring.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-clock" class="w-5 h-5"></i> Monitoring Kehadiran
                </a>
                <a href="<?php echo e(route('permits-review.index')); ?>" class="nav-link <?php echo e(request()->routeIs('permits-review.*') ? 'active' : ''); ?>">
                    <i data-lucide="calendar-off" class="w-5 h-5"></i> Pengajuan Izin
                </a>
                <a href="<?php echo e(route('final-reports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('final-reports.*') ? 'active' : ''); ?>">
                    <i data-lucide="file-text" class="w-5 h-5"></i> Laporan Akhir
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                    <i data-lucide="user-round" class="w-5 h-5"></i> Profil
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>

    <?php if(auth()->guard()->check()): ?>
        <div class="px-3 pb-5 pt-3 border-t border-white/10">
            <div class="flex items-center gap-3 px-2 py-2 mb-2">
                <div class="w-9 h-9 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                    <i data-lucide="user-round" class="w-5 h-5 text-emerald-400"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                    <span class="badge <?php echo e(auth()->user()->isAdmin() ? 'bg-amber-500/20 text-amber-300' : (auth()->user()->isMentor() ? 'bg-emerald-500/20 text-emerald-300' : 'bg-indigo-500/20 text-indigo-300')); ?> mt-0.5">
                        <i data-lucide="<?php echo e(auth()->user()->isAdmin() ? 'shield-check' : (auth()->user()->isMentor() ? 'user-check' : 'user-round')); ?>" class="w-3.5 h-3.5"></i>
                        <?php echo e(auth()->user()->isAdmin() ? 'Admin' : (auth()->user()->isMentor() ? 'Mentor' : 'Mahasiswa')); ?>

                    </span>
                </div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-link w-full">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Keluar
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/partials/sidebar-content.blade.php ENDPATH**/ ?>