<?php $__env->startSection('title', 'Kinerja - ' . ($internship->student->name ?? 'Mahasiswa')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.performance-monitoring.index')); ?>" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Monitoring Kinerja
    </a>
    <h1 class="text-2xl font-bold text-slate-900"><?php echo e($internship->student->name ?? '-'); ?></h1>
    <p class="text-slate-500 mt-1">
        <?php echo e($internship->period->name ?? '-'); ?>

        <?php if($internship->mentor): ?> &middot; Mentor: <?php echo e($internship->mentor->name); ?> <?php endif; ?>
    </p>
</div>

<div class="grid lg:grid-cols-2 gap-4 mb-6">
    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginal01231550773a572f7b3aef54b5fce16f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01231550773a572f7b3aef54b5fce16f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.progress-bar-labeled','data' => ['label' => 'Progress Logbook Harian','icon' => 'clipboard-list','value' => $internship->logbookProgressPercentage()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('progress-bar-labeled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Progress Logbook Harian','icon' => 'clipboard-list','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($internship->logbookProgressPercentage())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01231550773a572f7b3aef54b5fce16f)): ?>
<?php $attributes = $__attributesOriginal01231550773a572f7b3aef54b5fce16f; ?>
<?php unset($__attributesOriginal01231550773a572f7b3aef54b5fce16f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01231550773a572f7b3aef54b5fce16f)): ?>
<?php $component = $__componentOriginal01231550773a572f7b3aef54b5fce16f; ?>
<?php unset($__componentOriginal01231550773a572f7b3aef54b5fce16f); ?>
<?php endif; ?>
        <p class="text-xs text-slate-400 mt-3">
            <?php echo e($logbookTotals['approved']); ?> entri disetujui dari <?php echo e($internship->workingDaysElapsed()); ?> hari kerja yang sudah berjalan sejak <?php echo e($internship->start_date->translatedFormat('d M Y')); ?>.
        </p>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginal01231550773a572f7b3aef54b5fce16f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01231550773a572f7b3aef54b5fce16f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.progress-bar-labeled','data' => ['label' => 'Progress Laporan Akhir','icon' => 'file-text','value' => $internship->reportProgressPercentage()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('progress-bar-labeled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Progress Laporan Akhir','icon' => 'file-text','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($internship->reportProgressPercentage())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01231550773a572f7b3aef54b5fce16f)): ?>
<?php $attributes = $__attributesOriginal01231550773a572f7b3aef54b5fce16f; ?>
<?php unset($__attributesOriginal01231550773a572f7b3aef54b5fce16f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01231550773a572f7b3aef54b5fce16f)): ?>
<?php $component = $__componentOriginal01231550773a572f7b3aef54b5fce16f; ?>
<?php unset($__componentOriginal01231550773a572f7b3aef54b5fce16f); ?>
<?php endif; ?>
        <p class="text-xs text-slate-400 mt-3">
            Status laporan saat ini:
            <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['status' => $internship->finalReport?->status ?? 'draft']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($internship->finalReport?->status ?? 'draft')]); ?><?php echo e(ucfirst($internship->finalReport?->status ?? 'Belum ada')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
        </p>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
</div>

<?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => 'Laporan Akhir','class' => 'mb-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Laporan Akhir','class' => 'mb-6']); ?>
    <?php if($internship->finalReport && $internship->finalReport->status === 'approved' && $internship->finalReport->file_path): ?>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="font-medium text-slate-800"><?php echo e($internship->finalReport->title ?: 'Laporan Akhir Magang'); ?></p>
                <p class="text-sm text-slate-500 mt-0.5">Sudah disetujui mentor &middot; siap dilihat/diunduh.</p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.performance-monitoring.report-preview', $internship)); ?>" target="_blank" class="btn btn-secondary">
                    <i data-lucide="eye" class="w-4 h-4"></i> Preview
                </a>
                <a href="<?php echo e(route('admin.performance-monitoring.report-download', $internship)); ?>" class="btn btn-primary">
                    <i data-lucide="download" class="w-4 h-4"></i> Unduh
                </a>
            </div>
        </div>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Laporan belum tersedia','description' => 'Laporan akhir mahasiswa ini belum diunggah, atau sudah diunggah namun belum disetujui oleh mentor pembimbing.','icon' => 'file-x']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Laporan belum tersedia','description' => 'Laporan akhir mahasiswa ini belum diunggah, atau sudah diunggah namun belum disetujui oleh mentor pembimbing.','icon' => 'file-x']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => 'Logbook Harian (Disetujui Mentor)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Logbook Harian (Disetujui Mentor)']); ?>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div class="flex gap-4 text-sm text-slate-500">
            <span><span class="font-semibold text-emerald-600"><?php echo e($logbookTotals['approved']); ?></span> disetujui</span>
            <span><span class="font-semibold text-amber-600"><?php echo e($logbookTotals['submitted']); ?></span> menunggu review</span>
            <span><span class="font-semibold text-red-600"><?php echo e($logbookTotals['rejected']); ?></span> ditolak</span>
        </div>
        <?php if($logbookTotals['approved'] > 0): ?>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.performance-monitoring.logbook-document', $internship)); ?>" target="_blank" class="btn btn-secondary">
                    <i data-lucide="eye" class="w-4 h-4"></i> Preview Dokumen
                </a>
                <a href="<?php echo e(route('admin.performance-monitoring.logbook-document', $internship)); ?>?unduh=1" target="_blank" class="btn btn-primary">
                    <i data-lucide="download" class="w-4 h-4"></i> Cetak / Unduh
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if($logbooks->isEmpty()): ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada logbook yang disetujui mentor','icon' => 'clipboard-x']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada logbook yang disetujui mentor','icon' => 'clipboard-x']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-500 text-xs uppercase">
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium">Jam</th>
                        <th class="px-4 py-3 font-medium">Aktivitas</th>
                        <th class="px-4 py-3 font-medium">Output</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $logbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-3 text-slate-700 font-medium whitespace-nowrap"><?php echo e($logbook->date->translatedFormat('d M Y')); ?></td>
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap"><?php echo e($logbook->start_time->format('H:i')); ?>&ndash;<?php echo e($logbook->end_time->format('H:i')); ?></td>
                            <td class="px-4 py-3 text-slate-800"><?php echo e($logbook->activity); ?></td>
                            <td class="px-4 py-3 text-slate-500"><?php echo e($logbook->output ? \Illuminate\Support\Str::limit($logbook->output, 60) : '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6"><?php echo e($logbooks->links()); ?></div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/admin/performance-monitoring/detail.blade.php ENDPATH**/ ?>