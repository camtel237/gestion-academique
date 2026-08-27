


<?php $__env->startSection('title', 'Fiche étudiant - EduManager'); ?>

<?php
    $pageTitle = 'Fiche étudiant';
    $pageSub = $etudiant->prenom . ' ' . $etudiant->nom;
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex justify-end gap-2">
        <a href="<?php echo e(route('etudiants.index')); ?>" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour
        </a>
       
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4 mb-6">
            <?php if($etudiant->photo): ?>
                <img src="<?php echo e(asset('storage/' . $etudiant->photo)); ?>" class="w-20 h-24 rounded-xl object-cover border border-slate-200">
            <?php else: ?>
                <div class="w-20 h-24 rounded-xl <?php echo e($etudiant->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600'); ?> text-white flex items-center justify-center text-2xl font-bold">
                    <?php echo e(strtoupper(substr($etudiant->prenom, 0, 1))); ?><?php echo e(strtoupper(substr($etudiant->nom, 0, 1))); ?>

                </div>
            <?php endif; ?>
            <div>
                <h2 class="text-xl font-bold text-slate-800"><?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?></h2>
                <p class="text-sm text-slate-500">Matricule : <span class="font-semibold text-brand-700"><?php echo e($etudiant->matricule); ?></span></p>
                <span class="inline-block mt-1 px-2 py-1 rounded-full text-xs font-semibold <?php echo e($etudiant->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                    <?php echo e($etudiant->est_actif ? 'Actif' : 'Inactif'); ?>

                </span>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm border-t border-slate-100 pt-5">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Sexe</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->sexe === 'M' ? 'Masculin' : 'Féminin'); ?></p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Date de naissance</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '-'); ?></p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Lieu de naissance</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->lieu_naissance ?? '-'); ?></p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Email</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->email ?? '-'); ?></p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Téléphone</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->telephone ?? '-'); ?></p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Adresse</p>
                <p class="text-slate-700 mt-0.5"><?php echo e($etudiant->adresse ?? '-'); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Historique des inscriptions</h3>
        <?php $__empty_1 = true; $__currentLoopData = $etudiant->inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                <div>
                    <p class="font-semibold text-slate-700"><?php echo e($inscription->specialite->libelle ?? '-'); ?> — <?php echo e($inscription->niveau->libelle ?? '-'); ?></p>
                    <p class="text-xs text-slate-400"><?php echo e($inscription->departement->libelle ?? '-'); ?> · <?php echo e($inscription->anneeAcademique->libelle ?? '-'); ?></p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($inscription->statut === 'validee' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'); ?>">
                    <?php echo e(ucfirst($inscription->statut)); ?>

                </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-500">Aucune inscription enregistrée.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etudiants/show.blade.php ENDPATH**/ ?>