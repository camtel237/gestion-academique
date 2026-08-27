<?php $__env->startSection('title', 'Détails année académique - EduManager'); ?>

<?php
    $pageTitle = 'Détails année académique';
    $pageSub = 'Informations complètes de l\'année';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800"><?php echo e($anneeAcademique->libelle); ?></h3>
                    <p class="text-sm text-slate-500 mt-1">
                        <?php echo e($anneeAcademique->date_debut?->format('d/m/Y')); ?> - <?php echo e($anneeAcademique->date_fin?->format('d/m/Y')); ?>

                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo e($anneeAcademique->est_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                        <?php echo e($anneeAcademique->est_active ? 'Actif' : 'Inactif'); ?>

                    </span>
                  
                </div>
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($anneeAcademique->libelle); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Note de validation</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($anneeAcademique->note_validation); ?>/20</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date début</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($anneeAcademique->date_debut?->format('d/m/Y')); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date fin</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($anneeAcademique->date_fin?->format('d/m/Y')); ?></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</label>
                    <p class="text-slate-800 mt-1"><?php echo e($anneeAcademique->description ?? 'Aucune description'); ?></p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations supplémentaires</h4>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($anneeAcademique->niveaux->count()); ?></div>
                        <div class="text-xs text-slate-500">Niveaux</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($anneeAcademique->semestres->count()); ?></div>
                        <div class="text-xs text-slate-500">Semestres</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($anneeAcademique->unitesEnseignement->count()); ?></div>
                        <div class="text-xs text-slate-500">Unités d\'enseignement</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <a href="<?php echo e(route('annees-academiques.index')); ?>"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
           
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etablissement/annees/show.blade.php ENDPATH**/ ?>