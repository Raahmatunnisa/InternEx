<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Belum ada data', 'description' => null, 'icon' => 'inbox']));

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

foreach (array_filter((['title' => 'Belum ada data', 'description' => null, 'icon' => 'inbox']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="flex flex-col items-center justify-center text-center py-14 px-4">
    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
        <i data-lucide="<?php echo e($icon); ?>" class="w-8 h-8 text-slate-400"></i>
    </div>
    <h3 class="text-sm font-semibold text-slate-700"><?php echo e($title); ?></h3>
    <?php if($description): ?>
        <p class="text-sm text-slate-500 mt-1 max-w-sm"><?php echo e($description); ?></p>
    <?php endif; ?>
    <?php if(isset($action)): ?>
        <div class="mt-4"><?php echo e($action); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/empty-state.blade.php ENDPATH**/ ?>