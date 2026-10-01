<?php $__env->startSection('title', 'Laporan Akhir'); ?>

<?php $__env->startSection('content'); ?>
<?php
$steps = ['draft' => 'Draft', 'submitted' => 'Submitted', 'reviewed' => 'Reviewed', 'approved' => 'Approved'];
$stepKeys = array_keys($steps);
$currentIndex = $finalReport->status === 'revision' ? 1 : array_search($finalReport->status, $stepKeys);
$canEdit = auth()->user()->can('update', $finalReport);
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Laporan Akhir</h1>
    <p class="text-slate-500 mt-1">Dokumentasikan perjalanan dan hasil magangmu.</p>
</div>

<?php if (isset($component)) { $__componentOriginal4fe394949f0a1c422310f5213af8e626 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fe394949f0a1c422310f5213af8e626 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo-banner','data' => ['context' => 'final-report.banner','title' => 'Laporan akhir yang baik mencerminkan kualitas kerja','subtitle' => 'Susun laporan secara ringkas, jelas, dan didukung data yang relevan.','alt' => 'Suasana penyusunan laporan magang','heightClass' => 'h-28 sm:h-36']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['context' => 'final-report.banner','title' => 'Laporan akhir yang baik mencerminkan kualitas kerja','subtitle' => 'Susun laporan secara ringkas, jelas, dan didukung data yang relevan.','alt' => 'Suasana penyusunan laporan magang','heightClass' => 'h-28 sm:h-36']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fe394949f0a1c422310f5213af8e626)): ?>
<?php $attributes = $__attributesOriginal4fe394949f0a1c422310f5213af8e626; ?>
<?php unset($__attributesOriginal4fe394949f0a1c422310f5213af8e626); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fe394949f0a1c422310f5213af8e626)): ?>
<?php $component = $__componentOriginal4fe394949f0a1c422310f5213af8e626; ?>
<?php unset($__componentOriginal4fe394949f0a1c422310f5213af8e626); ?>
<?php endif; ?>


<?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'mb-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-6']); ?>
    <div class="flex items-center">
        <?php $__currentLoopData = $stepKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center <?php echo e(!$loop->last ? 'flex-1' : ''); ?>">
                <div class="flex flex-col items-center">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold
                        <?php echo e($i <= $currentIndex ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400'); ?>">
                        <?php if($i < $currentIndex): ?> <i data-lucide="check" class="w-4 h-4"></i> <?php else: ?> <?php echo e($i + 1); ?> <?php endif; ?>
                    </div>
                    <span class="text-xs mt-1.5 <?php echo e($i <= $currentIndex ? 'text-slate-800 font-medium' : 'text-slate-400'); ?>"><?php echo e($steps[$key]); ?></span>
                </div>
                <?php if(!$loop->last): ?>
                    <div class="flex-1 h-0.5 mx-2 <?php echo e($i < $currentIndex ? 'bg-indigo-600' : 'bg-slate-100'); ?>"></div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php if($finalReport->status === 'revision'): ?>
        <div class="mt-4">
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?>
                <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
                <span>Mentor meminta Anda untuk merevisi laporan ini. Silakan perbarui dan kirim ulang.</span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
        </div>
    <?php elseif(!$canEdit): ?>
        <div class="mt-4">
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info']); ?>
                <i data-lucide="lock" class="w-5 h-5 shrink-0"></i>
                <span>
                    <?php if($finalReport->status === 'submitted'): ?>
                        Laporan sudah dikirim dan sedang menunggu review mentor. Anda tidak dapat mengedit sampai mentor memberi feedback.
                    <?php elseif($finalReport->status === 'reviewed'): ?>
                        Laporan sedang dalam proses review mentor. Anda tidak dapat mengedit sampai proses review selesai.
                    <?php elseif($finalReport->status === 'approved'): ?>
                        Laporan akhir Anda sudah disetujui mentor. Tidak ada lagi perubahan yang diperlukan.
                    <?php endif; ?>
                </span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
        </div>
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

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => 'Informasi Laporan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Informasi Laporan']); ?>
            <?php if($canEdit): ?>
                <form method="POST" action="<?php echo e(route('final-report.update', $finalReport)); ?>" enctype="multipart/form-data" class="space-y-5">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['name' => 'title','label' => 'Judul Laporan','value' => $finalReport->title,'required' => true,'placeholder' => 'Judul laporan akhir magang']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'title','label' => 'Judul Laporan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($finalReport->title),'required' => true,'placeholder' => 'Judul laporan akhir magang']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['name' => 'abstract','label' => 'Abstract / Ringkasan','rows' => '6','required' => true,'placeholder' => 'Ringkasan singkat laporan akhir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'abstract','label' => 'Abstract / Ringkasan','rows' => '6','required' => true,'placeholder' => 'Ringkasan singkat laporan akhir']); ?><?php echo e($finalReport->abstract); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

                    <div>
                        <label for="file" class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 p-6 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition">
                            <i data-lucide="upload" class="w-6 h-6 text-slate-400"></i>
                            <span class="text-sm text-slate-500">Unggah file laporan (PDF, DOC, DOCX &middot; maks 10MB)</span>
                            <input type="file" name="file" id="file" class="hidden" onchange="previewFileName(this, 'file-name')">
                        </label>
                        <p id="file-name" class="hidden mt-2 text-sm text-slate-700 font-medium"></p>
                        <?php if($finalReport->file_path): ?>
                            <p class="mt-2 text-sm text-slate-500">File saat ini: <a href="<?php echo e(route('final-report.preview', $finalReport)); ?>" target="_blank" class="text-indigo-600 hover:underline">Lihat file</a></p>
                        <?php endif; ?>
                        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="btn btn-secondary">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Draft
                        </button>
                    </div>
                </form>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('submit', $finalReport)): ?>
                    <form method="POST" action="<?php echo e(route('final-report.submit', $finalReport)); ?>" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="send" class="w-4 h-4"></i> Kirim Laporan untuk Direview
                        </button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <dl class="space-y-4 text-sm">
                    <div><dt class="text-slate-400 mb-1">Judul Laporan</dt><dd class="text-slate-700 font-medium"><?php echo e($finalReport->title ?? '-'); ?></dd></div>
                    <div><dt class="text-slate-400 mb-1">Abstract</dt><dd class="text-slate-700 whitespace-pre-line"><?php echo e($finalReport->abstract ?? '-'); ?></dd></div>
                    <?php if($finalReport->file_path): ?>
                        <div><dt class="text-slate-400 mb-1">File Laporan</dt><dd>
                            <a href="<?php echo e(route('final-report.preview', $finalReport)); ?>" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-medium">
                                <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Laporan
                            </a>
                        </dd></div>
                    <?php endif; ?>
                </dl>
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
    </div>

    <div class="lg:col-span-1">
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => 'Feedback Mentor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Feedback Mentor']); ?>
            <?php if($finalReport->feedbacks->isEmpty()): ?>
                <p class="text-sm text-slate-500 text-center py-4">Belum ada feedback.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $finalReport->feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-semibold text-slate-800"><?php echo e($feedback->mentor->name); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($feedback->created_at->translatedFormat('d M Y')); ?></p>
                            </div>
                            <p class="text-sm text-slate-600"><?php echo e($feedback->feedback); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/final-report/show.blade.php ENDPATH**/ ?>