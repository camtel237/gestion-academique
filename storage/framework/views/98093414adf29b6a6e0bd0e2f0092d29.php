


<?php $__env->startSection('title', 'Aperçu du relevé - EduManager'); ?>

<?php
    $pageTitle = 'Aperçu du relevé de notes';
    $pageSub = $inscription->etudiant->prenom . ' ' . $inscription->etudiant->nom;
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex justify-end gap-2 mb-4">
        <a href="<?php echo e(route('effectifs.index')); ?>"
           class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition bg-white">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour
        </a>
        <a href="<?php echo e(route('releves.download', $inscription->id)); ?>"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-download mr-1"></i> Télécharger le PDF
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="height: 80vh;">
        <iframe src="<?php echo e(route('releves.preview', $inscription->id)); ?>" class="w-full h-full" style="border:none;"></iframe>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/effets/releves/show.blade.php ENDPATH**/ ?>