<?php $__env->startSection('title', 'Niveaux - EduManager'); ?>

<?php
    $pageTitle = 'Niveaux';
    $pageSub = 'Gestion des niveaux par spécialité et année';
?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="flex flex-wrap gap-2 flex-1">
        <div class="relative max-w-sm flex-1 min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <form method="GET" action="<?php echo e(route('niveaux.index')); ?>" class="inline">
                <input type="text" name="search" placeholder="Rechercher un niveau..."
                       value="<?php echo e(request('search')); ?>"
                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="<?php echo e(route('niveaux.index')); ?>" class="inline">
                <select name="specialite_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les spécialités</option>
                    <?php $__currentLoopData = $specialites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialite->id); ?>" <?php echo e(request('specialite_id') == $specialite->id ? 'selected' : ''); ?>>
                            <?php echo e($specialite->libelle); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>
    </div>
    <div class="flex gap-2 flex-wrap">
       
       
        <a href="<?php echo e(route('niveaux.create')); ?>"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouveau niveau
        </a>
    </div>
</div>


<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Département</th>
                    <th class="px-4 py-3 text-left font-semibold">Spécialité</th>
                    <th class="px-4 py-3 text-left font-semibold">Année académique</th>
                    <th class="px-4 py-3 text-left font-semibold">UE</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700"><?php echo e($niveau->libelle); ?></td>
                    <td class="px-4 py-3"><?php echo e($niveau->departement->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($niveau->specialite->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($niveau->anneeAcademique->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            <?php echo e($niveau->unitesEnseignement->count()); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($niveau->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e($niveau->est_actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?php echo e(route('niveaux.show', $niveau)); ?>"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="<?php echo e(route('niveaux.edit', $niveau)); ?>"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="<?php echo e(route('niveaux.toggle-status', $niveau)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="w-8 h-8 rounded-lg <?php echo e($niveau->est_actif ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-green-100 text-green-600 hover:bg-green-200'); ?> inline-flex items-center justify-center ml-1 transition"
                                    title="<?php echo e($niveau->est_actif ? 'Désactiver' : 'Activer'); ?>">
                                <i class="fa-solid <?php echo e($niveau->est_actif ? 'fa-pause' : 'fa-play'); ?> text-xs"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('niveaux.destroy', $niveau)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" onclick="askDeleteConfirm(this.closest('form'), 'Supprimer le niveau <?php echo e($niveau->libelle); ?> ?')"
                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-stairs text-4xl text-slate-300 mb-2 block"></i>
                        Aucun niveau trouvé
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?php echo e($niveaux->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etablissement/niveaux/index.blade.php ENDPATH**/ ?>