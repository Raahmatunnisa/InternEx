
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'context',
    'alt' => 'Ilustrasi kegiatan magang',
    'overlay' => true,
    'priority' => false,
    'fallbackIcon' => 'image',
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
    'alt' => 'Ilustrasi kegiatan magang',
    'overlay' => true,
    'priority' => false,
    'fallbackIcon' => 'image',
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
<div <?php echo e($attributes->merge(['class' => 'relative w-full h-full min-h-[180px] rounded-2xl overflow-hidden'])); ?>>
    <?php if($url): ?>
        <img
            src="<?php echo e($url); ?>"
            alt="<?php echo e($alt); ?>"
            class="absolute inset-0 w-full h-full object-cover"
            <?php if($priority): ?> fetchpriority="high" loading="eager" <?php else: ?> loading="lazy" <?php endif; ?>
        >
        <?php if($overlay): ?>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/70 via-[#0F172A]/10 to-transparent"></div>
        <?php endif; ?>
    <?php else: ?>
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-[#0F172A] flex items-center justify-center">
            <i data-lucide="<?php echo e($fallbackIcon); ?>" class="w-10 h-10 text-white/40"></i>
        </div>
    <?php endif; ?>

    <?php if(isset($slot)): ?>
        <div class="relative h-full flex flex-col justify-end p-6">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/photo-hero.blade.php ENDPATH**/ ?>