<?php $__env->startSection('title', 'Détails département - EduManager'); ?>

<?php
    $pageTitle = 'Détails département';
    $pageSub = 'Informations complètes du département';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800"><?php echo e($departement->libelle); ?></h3>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($departement->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e($departement->est_actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">Code: <?php echo e($departement->code); ?></p>
                </div>
               
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($departement->code); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($departement->libelle); ?></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</label>
                    <p class="text-slate-800 mt-1"><?php echo e($departement->description ?? 'Aucune description'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Chef de département</label>
                    <?php if($departement->chefDepartement): ?>
                        <p class="text-slate-800 font-medium mt-1">
                            <?php echo e($departement->chefDepartement->prenom); ?> <?php echo e($departement->chefDepartement->nom); ?>

                            <span class="text-sm text-slate-500 block"><?php echo e($departement->chefDepartement->matricule); ?></span>
                        </p>
                    <?php else: ?>
                        <p class="text-slate-400 mt-1">Non défini</p>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($departement->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e($departement->est_actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </p>
                </div>
            </div>

            <!-- Statistiques avec affichage du nombre de spécialités -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations supplémentaires</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($departement->specialites->count()); ?></div>
                        <div class="text-xs text-slate-500">Spécialités</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($departement->niveaux->count()); ?></div>
                        <div class="text-xs text-slate-500">Niveaux</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600"><?php echo e($departement->matieres->count()); ?></div>
                        <div class="text-xs text-slate-500">Matières</div>
                    </div>
                </div>

                <!-- Liste des spécialités du département -->
                <?php if($departement->specialites->count() > 0): ?>
                    <div class="mt-4">
                        <h5 class="text-sm font-semibold text-slate-600 mb-2">Spécialités du département</h5>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $departement->specialites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-medium">
                                    <?php echo e($specialite->libelle); ?>

                                    <span class="text-brand-400 ml-1">(<?php echo e($specialite->code); ?>)</span>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="<?php echo e(route('departements.index')); ?>"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>

            <a href="<?php echo e(route('specialites.create')); ?>?departement_id=<?php echo e($departement->id); ?>"
               class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-emerald-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> Ajouter une spécialité
            </a>
          
           
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etablissement/departements/show.blade.php ENDPATH**/ ?>