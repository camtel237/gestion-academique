<?php $__env->startSection('title', 'Liste des étudiants - EduManager'); ?>

<?php
    $pageTitle = 'Liste des étudiants';
    $pageSub = 'Gestion des étudiants inscrits';
?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="relative max-w-sm flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <form method="GET" action="<?php echo e(route('etudiants.index')); ?>" class="inline">
            <input type="text" name="search" placeholder="Rechercher un étudiant..."
                   value="<?php echo e(request('search')); ?>"
                   class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
        </form>
    </div>
    <div class="flex gap-2 flex-wrap">
        <button onclick="toast('Export Excel lancé', 'info')"
                class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="<?php echo e(route('etudiants.create')); ?>"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-user-plus mr-1"></i> Nouvel étudiant
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Matricule</th>
                    <th class="px-4 py-3 text-left font-semibold">Photo</th>
                    <th class="px-4 py-3 text-left font-semibold">Nom complet</th>
                    <th class="px-4 py-3 text-left font-semibold">Sexe</th>
                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                    <th class="px-4 py-3 text-left font-semibold">Téléphone</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $etudiants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etudiant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700"><?php echo e($etudiant->matricule); ?></td>
                    <td class="px-4 py-3">
                        <?php if($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)): ?>
                            
                            <img src="<?php echo e(asset('storage/' . $etudiant->photo)); ?>" 
                                 alt="<?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?>"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-brand-200"
                                 loading="lazy">
                        <?php else: ?>
                            
                            <div class="w-10 h-10 rounded-full <?php echo e($etudiant->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600'); ?> text-white flex items-center justify-center text-xs font-semibold">
                                <?php echo e(strtoupper(substr($etudiant->prenom, 0, 1))); ?><?php echo e(strtoupper(substr($etudiant->nom, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3"><?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?></td>
                    <td class="px-4 py-3"><?php echo e($etudiant->sexe === 'M' ? 'Masculin' : 'Féminin'); ?></td>
                    <td class="px-4 py-3"><?php echo e($etudiant->email ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($etudiant->telephone ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($etudiant->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e($etudiant->est_actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?php echo e(route('etudiants.show', $etudiant)); ?>"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="<?php echo e(route('etudiants.edit', $etudiant)); ?>"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="<?php echo e(route('etudiants.toggle-status', $etudiant)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="w-8 h-8 rounded-lg <?php echo e($etudiant->est_actif ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-green-100 text-green-600 hover:bg-green-200'); ?> inline-flex items-center justify-center ml-1 transition"
                                    title="<?php echo e($etudiant->est_actif ? 'Désactiver' : 'Activer'); ?>">
                                <i class="fa-solid <?php echo e($etudiant->est_actif ? 'fa-pause' : 'fa-play'); ?> text-xs"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('etudiants.destroy', $etudiant)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de cet étudiant ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition"
                                    title="Supprimer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-8 text-slate-500">
                        <i class="fa-solid fa-users text-4xl text-slate-300 mb-2 block"></i>
                        Aucun étudiant trouvé
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4"><?php echo e($etudiants->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/etudiants/index.blade.php ENDPATH**/ ?>