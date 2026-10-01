
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'context',
    'title' => null,
    'subtitle' => null,
    'alt' => 'Ilustrasi kegiatan magang',
    'heightClass' => 'h-32 sm:h-40',
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
    'context',
    'title' => null,
    'subtitle' => null,
    'alt' => 'Ilustrasi kegiatan magang',
    'heightClass' => 'h-32 sm:h-40',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$url = \App\Support\Photos::url($context);
?>
<div <?php echo e($attributes->merge(['class' => "relative w-full $heightClass rounded-2xl overflow-hidden mb-6"])); ?>>
    <?php if($url): ?>
        <img src="<?php echo e($url); ?>" alt="<?php echo e($alt); ?>" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A]/80 via-[#0F172A]/40 to-transparent"></div>
    <?php else: ?>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] to-indigo-700"></div>
    <?php endif; ?>

    <?php if($title): ?>
        <div class="relative h-full flex flex-col justify-center px-6 sm:px-8">
            <h2 class="text-lg sm:text-xl font-bold text-white"><?php echo e($title); ?></h2>
            <?php if($subtitle): ?>
                <p class="text-sm text-white/80 mt-1 max-w-md"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/photo-banner.blade.php ENDPATH**/ ?>