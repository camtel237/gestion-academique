


 
<?php $__env->startSection('title', 'Certificats de scolarité - EduManager'); ?>
 
<?php
    $pageTitle = 'Certificats de scolarité';
    $pageSub = 'Générer les certificats à partir des inscriptions validées';
?>
 
<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="relative max-w-sm flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un étudiant..."
               onkeyup="filterTable()"
               class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition">
    </div>
</div>
 
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm" id="certificatsTable">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Matricule</th>
                    <th class="px-4 py-3 text-left font-semibold">Étudiant</th>
                    <th class="px-4 py-3 text-left font-semibold">Département</th>
                    <th class="px-4 py-3 text-left font-semibold">Spécialité</th>
                    <th class="px-4 py-3 text-left font-semibold">Niveau</th>
                    <th class="px-4 py-3 text-left font-semibold">Année</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700"><?php echo e($inscription->etudiant->matricule); ?></td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full <?php echo e($inscription->etudiant->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600'); ?> text-white flex items-center justify-center text-xs font-semibold">
                                <?php echo e(strtoupper(substr($inscription->etudiant->prenom, 0, 1))); ?><?php echo e(strtoupper(substr($inscription->etudiant->nom, 0, 1))); ?>

                            </div>
                            <span><?php echo e($inscription->etudiant->nom_complet); ?></span>
                        </div>
                    </td>
                    <td class="px-4 py-3"><?php echo e($inscription->departement->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($inscription->specialite->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($inscription->niveau->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($inscription->anneeAcademique->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?php echo e(route('certificats.show', $inscription->id)); ?>"
                           class="px-3 py-1.5 bg-brand-50 text-brand-700 rounded-lg text-xs font-semibold hover:bg-brand-100 transition">
                            <i class="fa-solid fa-eye mr-1"></i> Aperçu
                        </a>
                        <a href="<?php echo e(route('certificats.download', $inscription->id)); ?>"
                           class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition">
                            <i class="fa-solid fa-download mr-1"></i> PDF
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-8 text-slate-500">
                        <i class="fa-solid fa-file-lines text-4xl text-slate-300 mb-2 block"></i>
                        Aucune inscription validée trouvée
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
 
<div class="mt-4">
    <?php echo e($inscriptions->links()); ?>

</div>
 
<?php $__env->startPush('scripts'); ?>
<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('certificatsTable');
    const rows = table.getElementsByTagName('tr');
 
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        for (let j = 0; j < cells.length - 1; j++) {
            const text = cells[j].textContent || cells[j].innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? '' : 'none';
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/effets/certificats/index.blade.php ENDPATH**/ ?>