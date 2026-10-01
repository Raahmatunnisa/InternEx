<?php $__env->startSection('title', 'Edit Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.mahasiswa.index')); ?>" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Kelola Mahasiswa
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Edit Mahasiswa</h1>
</div>

<form method="POST" action="<?php echo e(route('admin.mahasiswa.update', $mahasiswa)); ?>">
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('admin.mahasiswa._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/admin/mahasiswa/edit.blade.php ENDPATH**/ ?>