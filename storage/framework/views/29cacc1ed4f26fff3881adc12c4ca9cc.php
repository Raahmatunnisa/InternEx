<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - InternX</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
</head>
<body class="min-h-screen bg-[#F8FAFC]">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        
        <div class="flex flex-col justify-center px-6 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-md mx-auto">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-900 leading-none">InternX</p>
                        <p class="text-xs text-slate-400 mt-1">Kontribusi. Berkembang. Berdampak.</p>
                    </div>
                </div>

                
                <div class="lg:hidden h-48 mb-8 rounded-2xl overflow-hidden">
                    <?php if (isset($component)) { $__componentOriginalb24c39058dc147690b7954e57ee2c84e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb24c39058dc147690b7954e57ee2c84e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo-carousel','data' => ['title' => 'Selamat Datang di InternX','subtitle' => 'Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur.','class' => 'h-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo-carousel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Selamat Datang di InternX','subtitle' => 'Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur.','class' => 'h-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb24c39058dc147690b7954e57ee2c84e)): ?>
<?php $attributes = $__attributesOriginalb24c39058dc147690b7954e57ee2c84e; ?>
<?php unset($__attributesOriginalb24c39058dc147690b7954e57ee2c84e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb24c39058dc147690b7954e57ee2c84e)): ?>
<?php $component = $__componentOriginalb24c39058dc147690b7954e57ee2c84e; ?>
<?php unset($__componentOriginalb24c39058dc147690b7954e57ee2c84e); ?>
<?php endif; ?>
                </div>

                <h1 class="text-xl font-bold text-slate-900 mb-1">Selamat Datang Kembali</h1>
                <p class="text-sm text-slate-500 mb-6">Masuk ke workspace InternX untuk melanjutkan aktivitas magangmu.</p>

                <?php if($errors->any()): ?>
                    <div class="mb-5">
                        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error']); ?>
                            <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
                            <span><?php echo e($errors->first()); ?></span>
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

                <form method="POST" action="<?php echo e(route('login.store')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Email','name' => 'email','type' => 'email','value' => ''.e(old('email')).'','required' => true,'autofocus' => true,'placeholder' => 'nama@kampus.ac.id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Email','name' => 'email','type' => 'email','value' => ''.e(old('email')).'','required' => true,'autofocus' => true,'placeholder' => 'nama@kampus.ac.id']); ?>
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
                    <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['label' => 'Password','name' => 'password','type' => 'password','required' => true,'placeholder' => 'Masukkan password','toggle' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Password','name' => 'password','type' => 'password','required' => true,'placeholder' => 'Masukkan password','toggle' => true]); ?>
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

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            Ingat saya
                        </label>
                    </div>

                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full']); ?>
                        <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Workspace
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                </form>

                <p class="text-xs text-center text-slate-400 mt-6">
                    Akun dibuat oleh administrator/mentor. Hubungi mentor Anda jika belum memiliki akun.
                </p>

                <div class="grid grid-cols-3 gap-3 mt-10 pt-6 border-t border-slate-200">
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-indigo-600"></i>
                        <p class="text-xs font-medium text-slate-600">Aktivitas Harian</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="calendar-check" class="w-5 h-5 text-emerald-600"></i>
                        <p class="text-xs font-medium text-slate-600">Kehadiran</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-1.5">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        <p class="text-xs font-medium text-slate-600">Laporan Akhir</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="hidden lg:block relative p-6">
            <?php if (isset($component)) { $__componentOriginalb24c39058dc147690b7954e57ee2c84e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb24c39058dc147690b7954e57ee2c84e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo-carousel','data' => ['title' => 'Selamat Datang di InternX','subtitle' => 'Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur.','class' => 'h-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo-carousel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Selamat Datang di InternX','subtitle' => 'Kelola perjalanan magangmu dengan lebih terstruktur, profesional, dan terukur.','class' => 'h-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb24c39058dc147690b7954e57ee2c84e)): ?>
<?php $attributes = $__attributesOriginalb24c39058dc147690b7954e57ee2c84e; ?>
<?php unset($__attributesOriginalb24c39058dc147690b7954e57ee2c84e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb24c39058dc147690b7954e57ee2c84e)): ?>
<?php $component = $__componentOriginalb24c39058dc147690b7954e57ee2c84e; ?>
<?php unset($__componentOriginalb24c39058dc147690b7954e57ee2c84e); ?>
<?php endif; ?>
        </div>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>