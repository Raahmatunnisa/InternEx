<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label' => null, 'name', 'type' => 'text', 'value' => null, 'required' => false, 'toggle' => false]));

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

foreach (array_filter((['label' => null, 'name', 'type' => 'text', 'value' => null, 'required' => false, 'toggle' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div>
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="form-label"><?php echo e($label); ?> <?php if($required): ?><span class="text-red-500">*</span><?php endif; ?></label>
    <?php endif; ?>
    <?php if($type === 'password' && $toggle): ?>
        <div class="relative">
            <input
                type="password"
                name="<?php echo e($name); ?>"
                id="<?php echo e($name); ?>"
                value="<?php echo e(old($name, $value)); ?>"
                <?php echo e($attributes->merge(['class' => 'form-input pr-11'])); ?>

                <?php if($required): ?> required <?php endif; ?>
            >
            <button
                type="button"
                onclick="togglePasswordVisibility('<?php echo e($name); ?>', this)"
                aria-label="Tampilkan/sembunyikan password"
                class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg"
            >
                <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
        </div>
    <?php else: ?>
        <input
            type="<?php echo e($type); ?>"
            name="<?php echo e($name); ?>"
            id="<?php echo e($name); ?>"
            value="<?php echo e(old($name, $value)); ?>"
            <?php echo e($attributes->merge(['class' => 'form-input'])); ?>

            <?php if($required): ?> required <?php endif; ?>
        >
    <?php endif; ?>
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1.5 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/components/input.blade.php ENDPATH**/ ?>