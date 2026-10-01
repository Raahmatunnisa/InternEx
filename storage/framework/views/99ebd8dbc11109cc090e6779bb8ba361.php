<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['value' => 0, 'color' => 'auto']));

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

foreach (array_filter((['value' => 0, 'color' => 'auto']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$percent = min(100, max(0, (float) $value));

$colorMap = [
    'indigo' => 'bg-indigo-600',
    'emerald' => 'bg-emerald-600',
    'amber' => 'bg-amber-600',
    'red' => 'bg-red-600',
    'blue' => 'bg-blue-600',
];

if ($color === 'auto') {
    $barColor = match (true) {
        $percent >= 70 => $colorMap['emerald'],
        $percent >= 40 => $colorMap['amber'],
        default => $colorMap['red'],
    };
} else {
    $barColor = $colorMap[$color] ?? $colorMap['indigo'];
}
?>
<div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
    <div class="h-full rounded-full <?php echo e($barColor); ?> transition-all" style="width: <?php echo e($percent); ?>%"></div>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/progress-bar.blade.php ENDPATH**/ ?>