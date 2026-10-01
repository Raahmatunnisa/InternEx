<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'icon' => 'activity', 'color' => 'indigo']));

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

foreach (array_filter((['label', 'value', 'icon' => 'activity', 'color' => 'indigo']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$colorMap = [
    'indigo' => ['bg-indigo-50', 'text-indigo-600'],
    'emerald' => ['bg-emerald-50', 'text-emerald-600'],
    'amber' => ['bg-amber-50', 'text-amber-600'],
    'red' => ['bg-red-50', 'text-red-600'],
    'blue' => ['bg-blue-50', 'text-blue-600'],
];
[$bg, $text] = $colorMap[$color] ?? $colorMap['indigo'];
?>
<div class="card p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500"><?php echo e($label); ?></p>
            <p class="text-2xl font-bold text-slate-900 mt-1"><?php echo e($value); ?></p>
        </div>
        <div class="w-11 h-11 rounded-xl <?php echo e($bg); ?> flex items-center justify-center">
            <i data-lucide="<?php echo e($icon); ?>" class="w-6 h-6 <?php echo e($text); ?>"></i>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/stat-card.blade.php ENDPATH**/ ?>