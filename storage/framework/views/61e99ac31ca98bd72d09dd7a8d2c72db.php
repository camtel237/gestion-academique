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
       <div class="flex gap-2">
    <a href="<?php echo e(route('etudiants.export')); ?>"
       class="px-4 py-2.5 bg-white border border-emerald-200 text-emerald-700 rounded-xl text-sm font-semibold hover:bg-emerald-50 transition flex items-center gap-2">
        <i class="fa-solid fa-file-export"></i> Exporter
    </a>
    <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden'); document.getElementById('importModal').classList.add('flex')"
            class="px-4 py-2.5 bg-white border border-sky-200 text-sky-700 rounded-xl text-sm font-semibold hover:bg-sky-50 transition flex items-center gap-2">
        <i class="fa-solid fa-file-import"></i> Importer
    </button>
</div>
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
                        <?php if($etudiant->photo): ?>
                            
                            <img src="<?php echo e(asset('storage/' . $etudiant->photo)); ?>" 
                                 alt="<?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?>"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-brand-200"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            
                            <div class="w-10 h-10 rounded-full <?php echo e($etudiant->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600'); ?> text-white items-center justify-center text-xs font-semibold" style="display:none;">
                                <?php echo e(strtoupper(substr($etudiant->prenom, 0, 1))); ?><?php echo e(strtoupper(substr($etudiant->nom, 0, 1))); ?>

                            </div>
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
                            <button type="button"
                                onclick="askDeleteConfirm(this.closest('form'), 'Supprimer l\'étudiant(e), <?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?> ?')"
                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition">
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

<div id="importModal" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-1">Importer des étudiants</h3>
        <p class="text-sm text-slate-500 mb-4">
            Fichier Excel (.xlsx, .xls) ou CSV avec au minimum les colonnes :
            <b>matricule, nom, prenom</b>.
        </p>

        <?php if(session('warning')): ?>
            <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800">
                <?php echo e(session('warning')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('etudiants.import')); ?>" method="POST" enctype="multipart/form-data" id="importForm">
            <?php echo csrf_field(); ?>
            <input type="file" name="fichier" accept=".xlsx,.xls,.csv" required
                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm mb-4">

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="document.getElementById('importModal').classList.add('hidden'); document.getElementById('importModal').classList.remove('flex')"
                        class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </button>
                <button type="submit" id="importSubmitBtn"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                    <span id="importSpinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                    Importer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('importForm').addEventListener('submit', function () {
    document.getElementById('importSubmitBtn').disabled = true;
    document.getElementById('importSpinner').classList.remove('hidden');
});

<?php if(session('warning')): ?>
document.getElementById('importModal').classList.remove('hidden');
document.getElementById('importModal').classList.add('flex');
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etudiants/index.blade.php ENDPATH**/ ?>