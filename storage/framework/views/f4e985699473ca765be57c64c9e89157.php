<?php $__env->startSection('title', 'Détails UE - EduManager'); ?>

<?php
    $pageTitle = 'Détails unité d\'enseignement';
    $pageSub = 'Informations complètes de l\'UE';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800"><?php echo e($ue->libelle); ?></h3>
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            <?php echo e($ue->code); ?>

                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">
                        <?php if($ue->niveau): ?>
                            <?php echo e($ue->niveau->libelle); ?>

                            <span class="text-xs text-slate-400">
                                (<?php echo e($ue->niveau->specialite->libelle ?? 'Sans spécialité'); ?>)
                            </span>
                        <?php else: ?>
                            <?php echo e('-'); ?>

                        <?php endif; ?>
                        • <?php echo e($ue->anneeAcademique->libelle ?? '-'); ?>

                    </p>
                </div>
               
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($ue->code); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($ue->libelle); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total crédits</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            <?php echo e($ue->total_credit); ?>

                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Position relevé</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($ue->position_releve ?? 'Non définie'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Niveau</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <?php if($ue->niveau): ?>
                            <?php echo e($ue->niveau->libelle); ?>

                            <span class="text-sm text-slate-500 block">
                                <?php echo e($ue->niveau->specialite->libelle ?? 'Sans spécialité'); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-slate-400">-</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Année académique</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($ue->anneeAcademique->libelle ?? '-'); ?></p>
                </div>
            </div>

            <!-- Matières -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-semibold text-slate-700">Matières de l'UE</h4>
                    <span class="text-xs text-slate-500"><?php echo e($ue->matieres->count()); ?> matière(s)</span>
                </div>
                <?php if($ue->matieres->count() > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <?php $__currentLoopData = $ue->matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-slate-800"><?php echo e($matiere->libelle); ?></span>
                                    <span class="text-xs text-slate-400 block"><?php echo e($matiere->code); ?></span>
                                </div>
                                <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded text-xs font-semibold">
                                    <?php echo e($matiere->credit); ?> crédits
                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-slate-500 text-center py-4">
                        <i class="fa-solid fa-book text-slate-300 mr-2"></i>
                        Aucune matière associée à cette UE
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="<?php echo e(route('ues.index')); ?>"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
           
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etablissement/ues/show.blade.php ENDPATH**/ ?>