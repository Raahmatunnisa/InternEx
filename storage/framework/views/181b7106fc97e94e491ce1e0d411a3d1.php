
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Selamat Datang',
    'subtitle' => null,
    'interval' => 5000,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Selamat Datang',
    'subtitle' => null,
    'interval' => 5000,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$slideContexts = \App\Support\Photos::loginSlides();
?>

<?php if(empty($slideContexts)): ?>
    
    <div <?php echo e($attributes->merge(['class' => 'relative w-full h-full min-h-[280px] rounded-2xl overflow-hidden bg-gradient-to-br from-[#0F172A] via-indigo-900 to-indigo-700 flex flex-col items-center justify-center text-center p-8'])); ?>>
        <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-5">
            <i data-lucide="clipboard-check" class="w-8 h-8 text-white"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2"><?php echo e($title); ?></h2>
        <?php if($subtitle): ?>
            <p class="text-white/70 max-w-sm"><?php echo e($subtitle); ?></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div
        <?php echo e($attributes->merge(['class' => 'relative w-full h-full min-h-[280px] rounded-2xl overflow-hidden'])); ?>

        data-carousel
        data-interval="<?php echo e($interval); ?>"
    >
        <div data-carousel-slides class="absolute inset-0">
            <?php $__currentLoopData = $slideContexts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $context): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img
                    src="<?php echo e(\App\Support\Photos::url($context)); ?>"
                    alt="Suasana kegiatan magang <?php echo e($i + 1); ?>"
                    data-carousel-slide
                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out <?php echo e($i === 0 ? 'opacity-100' : 'opacity-0'); ?>"
                    <?php if($i === 0): ?> fetchpriority="high" loading="eager" <?php else: ?> loading="lazy" <?php endif; ?>
                >
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/85 via-[#0F172A]/20 to-[#0F172A]/10"></div>

        
        <div class="relative h-full flex flex-col justify-end p-8">
            <h2 class="text-2xl font-bold text-white mb-2"><?php echo e($title); ?></h2>
            <?php if($subtitle): ?>
                <p class="text-white/80 max-w-sm mb-6"><?php echo e($subtitle); ?></p>
            <?php endif; ?>

            
            <div class="flex items-center gap-2" data-carousel-dots role="tablist" aria-label="Navigasi slide">
                <?php $__currentLoopData = $slideContexts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $context): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        type="button"
                        role="tab"
                        data-carousel-dot="<?php echo e($i); ?>"
                        aria-label="Ke slide <?php echo e($i + 1); ?>"
                        class="h-1.5 rounded-full transition-all duration-300 <?php echo e($i === 0 ? 'w-6 bg-white' : 'w-1.5 bg-white/40 hover:bg-white/60'); ?>"
                    ></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <button
            type="button"
            data-carousel-prev
            aria-label="Slide sebelumnya"
            class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur flex items-center justify-center text-white transition focus:outline-none focus:ring-2 focus:ring-white/60"
        >
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>
        <button
            type="button"
            data-carousel-next
            aria-label="Slide berikutnya"
            class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur flex items-center justify-center text-white transition focus:outline-none focus:ring-2 focus:ring-white/60"
        >
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/photo-carousel.blade.php ENDPATH**/ ?>