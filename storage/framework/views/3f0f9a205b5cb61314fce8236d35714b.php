


<?php $__env->startSection('title', 'Paramètres - EduManager'); ?>

<?php
    $pageTitle = 'Paramètres';
    $pageSub = "Informations générales de l'établissement";
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">

        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                <i class="fa-solid fa-circle-check mr-2"></i><?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i><?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('settings.update')); ?>" method="POST" class="space-y-4" id="settingsForm">
            <?php echo csrf_field(); ?>

            <?php $__currentLoopData = $champs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider"><?php echo e($label); ?></label>
                    <input type="<?php echo e($key === 'email' ? 'email' : 'text'); ?>" name="<?php echo e($key); ?>"
                           value="<?php echo e(old($key, $valeurs[$key])); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" id="settingsSubmitBtn"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                    <span id="settingsSpinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('settingsForm').addEventListener('submit', function () {
    document.getElementById('settingsSubmitBtn').disabled = true;
    document.getElementById('settingsSpinner').classList.remove('hidden');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/administration/settings.blade.php ENDPATH**/ ?>