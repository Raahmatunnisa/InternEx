
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'size' => 'w-11 h-11', 'textSize' => 'text-sm']));

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

foreach (array_filter((['name', 'size' => 'w-11 h-11', 'textSize' => 'text-sm']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$initials = collect(explode(' ', trim($name)))
    ->filter()
    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
    ->take(2)
    ->implode('');
?>
<div <?php echo e($attributes->merge(['class' => "$size rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold $textSize shrink-0"])); ?>>
    <?php echo e($initials ?: '?'); ?>

</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/avatar-initials.blade.php ENDPATH**/ ?>