<?php $__env->startSection('title', 'Détails employé - EduManager'); ?>

<?php
    $pageTitle = 'Détails employé';
    $pageSub = 'Informations complètes du personnel';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full <?php echo e($personnel->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600'); ?> text-white flex items-center justify-center text-2xl font-bold">
                        <?php echo e(strtoupper(substr($personnel->prenom, 0, 1))); ?><?php echo e(strtoupper(substr($personnel->nom, 0, 1))); ?>

                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800"><?php echo e($personnel->prenom); ?> <?php echo e($personnel->nom); ?></h3>
                        <p class="text-sm text-slate-500"><?php echo e($personnel->matricule); ?> • <?php echo e($personnel->fonction); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo e($personnel->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                        <?php echo e($personnel->est_actif ? 'Actif' : 'Inactif'); ?>

                    </span>
                    <?php if($personnel->user_id): ?>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700">
                            <i class="fa-solid fa-user-check"></i> Compte
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Matricule</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->matricule); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sexe</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->sexe === 'M' ? 'Masculin' : 'Féminin'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date de naissance</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->date_naissance?->format('d/m/Y') ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lieu de naissance</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->lieu_naissance ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->email ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Téléphone</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->telephone ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Fonction</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->fonction); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date d'embauche</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->date_embauche?->format('d/m/Y') ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Diplôme</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->diplome ?? '-'); ?></p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Adresse</label>
                    <p class="text-slate-800 font-medium mt-1"><?php echo e($personnel->adresse ?? '-'); ?></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Compte utilisateur</label>
                    <?php if($personnel->user_id): ?>
                        <p class="text-slate-800 font-medium mt-1">
                            <span class="text-green-600"><i class="fa-solid fa-check-circle"></i> Compte lié</span>
                            <span class="text-sm text-slate-500 ml-2">(<?php echo e($personnel->user->email ?? ''); ?>)</span>
                        </p>
                    <?php else: ?>
                        <p class="text-slate-800 font-medium mt-1">
                            <span class="text-amber-600"><i class="fa-solid fa-circle-exclamation"></i> Aucun compte</span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="<?php echo e(route('personnels.index')); ?>"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="<?php echo e(route('personnels.edit', $personnel)); ?>"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            <?php if(!$personnel->user_id): ?>
                <a href="<?php echo e(route('personnels.create-user', $personnel)); ?>"
                   class="px-4 py-2.5 bg-black text-white rounded-xl text-sm font-semibold shadow hover:bg-purple-700 transition">
                    <i class="fa-solid fa-user-plus mr-1"></i> Créer un compte
                </a>
            <?php else: ?>
                <form action="<?php echo e(route('personnels.detach-user', $personnel)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                            onclick="return confirm('Confirmer le détachement du compte utilisateur ?')"
                            class="px-4 py-2.5 bg-amber-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-amber-700 transition">
                        <i class="fa-solid fa-user-slash mr-1"></i> Détacher le compte
                    </button>
                </form>
            <?php endif; ?>
            <form action="<?php echo e(route('personnels.destroy', $personnel)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de cet employé ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/etablissement/personnels/show.blade.php ENDPATH**/ ?>