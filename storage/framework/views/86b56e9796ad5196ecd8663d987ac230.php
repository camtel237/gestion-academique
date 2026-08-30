


<?php $__env->startSection('title', 'Générer effectif - EduManager'); ?>

<?php
    $pageTitle = 'Générer effectif';
    $pageSub = 'Sélectionner une spécialité et un niveau pour générer les documents des étudiants';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-5">

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
               <select id="specialite_select"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                <option value="">Sélectionner une spécialité</option>
                <?php $__currentLoopData = $specialites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($specialite->id); ?>" <?php echo e(request('specialite_id') == $specialite->id ? 'selected' : ''); ?>>
                        <?php echo e($specialite->libelle); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        disabled>
                    <option value="">Sélectionner d'abord une spécialité</option>
                </select>
            </div>
        </div>
    </div>

    <div id="empty_state" class="bg-white rounded-2xl p-10 border border-slate-100 shadow-sm text-center text-slate-400">
        <i class="fa-solid fa-users text-3xl mb-3"></i>
        <p>Choisissez une spécialité puis un niveau pour afficher les étudiants et générer leurs effets académique.</p>
    </div>

    <div id="effectif_panel" class="bg-white rounded-2xl border border-slate-100 shadow-sm hidden">
        <div class="p-5 border-b border-slate-100">
            <p class="text-sm font-semibold text-slate-800" id="panel_header"></p>
        </div>

        <div id="table_loading" class="p-10 text-center text-slate-400 hidden">
            <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
            <p>Chargement de l'effectif...</p>
        </div>

        <div id="table_no_students" class="p-10 text-center text-slate-400 hidden">
            <i class="fa-solid fa-user-slash text-2xl mb-2"></i>
            <p>Aucun étudiant inscrit et validé pour ce niveau.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm hidden" id="effectif_table">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Matricule</th>
                        <th class="px-4 py-3 text-left">Étudiant</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="effectif_tbody" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const specialiteSelect = document.getElementById('specialite_select');
    const niveauSelect = document.getElementById('niveau_select');

    const emptyState = document.getElementById('empty_state');
    const panel = document.getElementById('effectif_panel');
    const panelHeader = document.getElementById('panel_header');
    const tableLoading = document.getElementById('table_loading');
    const tableNoStudents = document.getElementById('table_no_students');
    const table = document.getElementById('effectif_table');
    const tbody = document.getElementById('effectif_tbody');

    const params = new URLSearchParams(window.location.search);
    const initialSpecialiteId = params.get('specialite_id');
    const initialNiveauId = params.get('niveau_id');

    specialiteSelect.addEventListener('change', function () {
        niveauSelect.disabled = true;
        niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        hidePanel();
        if (!this.value) return;
        chargerNiveaux(this.value);
    });

    niveauSelect.addEventListener('change', function () {
        if (!this.value) { hidePanel(); return; }
        chargerEffectif(this.value);
    });

    function chargerNiveaux(specialiteId, preselectNiveauId = null) {
        niveauSelect.disabled = false;
        niveauSelect.innerHTML = '<option value="">Chargement...</option>';
        return fetch(`<?php echo e(route('effectifs.get-niveaux')); ?>?specialite_id=${specialiteId}`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) { niveauSelect.innerHTML = '<option value="">Aucun niveau pour cette spécialité</option>'; return; }
                niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                data.forEach(n => {
                    const opt = document.createElement('option');
                    opt.value = n.id; opt.textContent = n.libelle;
                    if (preselectNiveauId && n.id == preselectNiveauId) opt.selected = true;
                    niveauSelect.appendChild(opt);
                });
            });
    }

    function hidePanel() {
        panel.classList.add('hidden');
        emptyState.classList.remove('hidden');
        table.classList.add('hidden');
        tableNoStudents.classList.add('hidden');
    }

    function chargerEffectif(niveauId) {
        emptyState.classList.add('hidden');
        panel.classList.remove('hidden');
        table.classList.add('hidden');
        tableNoStudents.classList.add('hidden');
        tableLoading.classList.remove('hidden');

        const specialiteId = specialiteSelect.value;

        fetch(`<?php echo e(route('effectifs.get-etudiants')); ?>?niveau_id=${niveauId}`)
            .then(r => r.json())
            .then(data => {
                tableLoading.classList.add('hidden');
                const nbEtudiants = data.etudiants.length;
                const etudiantsTexte = nbEtudiants > 1 ? 'étudiants' : 'étudiant';
                panelHeader.textContent = `Effectif : ${data.specialite} - ${data.niveau} - ${data.annee} (${nbEtudiants} ${etudiantsTexte})`;

                if (!data.etudiants.length) {
                    tableNoStudents.classList.remove('hidden');
                    return;
                }

                // Query string à propager pour que "Retour" ramène ici avec la même sélection
                const retourQs = `specialite_id=${specialiteId}&niveau_id=${niveauId}`;

                tbody.innerHTML = '';
                data.etudiants.forEach(e => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-4 py-2.5 text-slate-500">${e.matricule}</td>
                        <td class="px-4 py-2.5 font-medium text-slate-700">${e.nom_complet}</td>
                        <td class="px-4 py-2.5 text-right whitespace-nowrap space-x-1">
                            <a href="/cartes-etudiant/${e.inscription_id}?${retourQs}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-200 text-xs font-semibold transition"
                               title="Générer la carte étudiant">
                                <i class="fa-solid fa-id-card"></i> Carte
                            </a>
                            <a href="/certificats-scolarite/${e.inscription_id}?${retourQs}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 text-xs font-semibold transition"
                               title="Générer le certificat de scolarité">
                                <i class="fa-solid fa-file-lines"></i> Certificat
                            </a>
                            <a href="/releves-notes/${e.inscription_id}?${retourQs}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-200 text-xs font-semibold transition"
                               title="Générer le relevé de notes">
                                <i class="fa-solid fa-table-list"></i> Relevé
                            </a>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                table.classList.remove('hidden');
            })
            .catch(() => {
                tableLoading.classList.add('hidden');
                tableNoStudents.classList.remove('hidden');
                tableNoStudents.querySelector('p').textContent = "Erreur lors du chargement de l'effectif.";
            });
    }

    // Restauration automatique de l'état depuis l'URL au chargement de la page
    if (initialSpecialiteId) {
        chargerNiveaux(initialSpecialiteId, initialNiveauId).then(() => {
            if (initialNiveauId) {
                chargerEffectif(initialNiveauId);
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/effets/effectifs/index.blade.php ENDPATH**/ ?>