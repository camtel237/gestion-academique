<?php $__env->startSection('title', 'Saisie des notes - EduManager'); ?>

<?php
    $pageTitle = 'Saisie des notes';
    $pageSub = 'Enregistrer les notes des étudiants';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">

        <?php if(!$anneeActive): ?>
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                Aucune année académique active. Activez une année dans "Années académiques" avant de saisir des notes.
            </div>
        <?php else: ?>
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold mb-1">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('notes.store')); ?>" method="POST" class="space-y-4" id="noteForm">
                <?php echo csrf_field(); ?>

                <!-- Année active (fixe, non modifiable) -->
                <div class="p-3 bg-brand-50 border border-brand-100 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-brand-800">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span class="font-semibold">Année académique active :</span>
                        <span><?php echo e($anneeActive->libelle); ?></span>
                    </div>
                </div>
                <input type="hidden" name="annee_academique_id" id="annee_select" value="<?php echo e($anneeActive->id); ?>">

                <!-- Spécialité + Semestre côte à côte -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                        <select name="specialite_id" id="specialite_select"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                                required>
                            <option value="">Sélectionner une spécialité</option>
                            <?php $__currentLoopData = $specialites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($specialite->id); ?>" <?php echo e($selectedSpecialite == $specialite->id ? 'selected' : ''); ?>>
                                    <?php echo e($specialite->libelle); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                        <select name="semestre_id" id="semestre_select"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                                required disabled>
                            <option value="">Sélectionner d'abord une spécialité</option>
                            <?php $__currentLoopData = $semestres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($semestre->id); ?>" <?php echo e($selectedSemestre == $semestre->id ? 'selected' : ''); ?>>
                                    <?php echo e($semestre->libelle); ?> (<?php echo e($semestre->niveau->libelle ?? ''); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Matière + Étudiant côte à côte -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Matière *</label>
                        <select name="matiere_id" id="matiere_select"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                                required disabled>
                            <option value="">Sélectionner d'abord un semestre</option>
                            <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($matiere->id); ?>" <?php echo e($selectedMatiere == $matiere->id ? 'selected' : ''); ?>>
                                    <?php echo e($matiere->libelle); ?> (<?php echo e($matiere->credit); ?> crédits)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Étudiant *</label>
                        <select name="etudiant_id" id="etudiant_select"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                                required disabled>
                            <option value="">Sélectionner d'abord une matière</option>
                            <?php $__currentLoopData = $etudiants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etudiant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($etudiant->id); ?>">
                                    <?php echo e($etudiant->nom_complet); ?> (<?php echo e($etudiant->matricule); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Champ caché -->
                <input type="hidden" name="inscription_id" id="inscription_id">

                <!-- Notes -->
                <div class="grid sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Contrôle continu (30%) *</label>
                        <input type="number" name="note_cc" id="note_cc"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                               step="0.5" min="0" max="20" placeholder="0-20" required>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Examen (70%) *</label>
                        <input type="number" name="note_examen" id="note_examen"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                               step="0.5" min="0" max="20" placeholder="0-20" required>
                    </div>
                </div>

                <!-- Résultat automatique -->
                <div class="p-4 bg-brand-50 border border-brand-200 rounded-xl text-sm text-brand-800" id="resultat">
                    <i class="fa-solid fa-calculator mr-2"></i>
                    Moyenne = (CC × 30%) + (Examen × 70%)
                    <span class="font-bold" id="moyenne_affichage">-</span>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="<?php echo e(route('notes.index')); ?>"
                       class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                        Annuler
                    </a>
                    <button type="submit" id="noteSubmitBtn"
                            class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                        <span id="noteSubmitSpinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                        <i class="fa-solid fa-floppy-disk" id="noteSubmitIcon"></i> Enregistrer la note
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const anneeSelect = document.getElementById('annee_select');
    if (!anneeSelect) return; // pas d'année active, formulaire non affiché

    const specialiteSelect = document.getElementById('specialite_select');
    const semestreSelect = document.getElementById('semestre_select');
    const matiereSelect = document.getElementById('matiere_select');
    const etudiantSelect = document.getElementById('etudiant_select');
    const inscriptionId = document.getElementById('inscription_id');
    const noteCc = document.getElementById('note_cc');
    const noteExamen = document.getElementById('note_examen');
    const moyenneAffichage = document.getElementById('moyenne_affichage');

    function resetSelects(selectIds) {
        selectIds.forEach(id => {
            const select = document.getElementById(id);
            if (select) {
                select.disabled = true;
                select.innerHTML = '<option value="">Sélectionner d\'abord</option>';
            }
        });
    }

    // 1. Semestres (avec niveau dans le libellé) par spécialité, pour l'année active
    specialiteSelect.addEventListener('change', function() {
        const specialiteId = this.value;
        resetSelects(['semestre_select', 'matiere_select', 'etudiant_select']);

        if (specialiteId) {
            semestreSelect.disabled = false;
            semestreSelect.innerHTML = '<option value="">Chargement...</option>';

            fetch(`/get-semestres-by-specialite?specialite_id=${specialiteId}&annee_academique_id=${anneeSelect.value}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.length) {
                        semestreSelect.innerHTML = '<option value="">Aucun semestre pour cette spécialité</option>';
                        return;
                    }
                    semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>';
                    data.forEach(semestre => {
                        const option = document.createElement('option');
                        option.value = semestre.id;
                        option.textContent = semestre.libelle;
                        semestreSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    semestreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            semestreSelect.disabled = true;
            semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    });

    // 2. Matières par semestre
    semestreSelect.addEventListener('change', function() {
        const semestreId = this.value;
        resetSelects(['matiere_select', 'etudiant_select']);

        if (semestreId) {
            matiereSelect.disabled = false;
            matiereSelect.innerHTML = '<option value="">Chargement...</option>';

            fetch(`/get-matieres-by-semestre?semestre_id=${semestreId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.length) {
                        matiereSelect.innerHTML = '<option value="">Aucune matière pour ce semestre</option>';
                        return;
                    }
                    matiereSelect.innerHTML = '<option value="">Sélectionner une matière</option>';
                    data.forEach(matiere => {
                        const option = document.createElement('option');
                        option.value = matiere.id;
                        option.textContent = matiere.libelle + ' (' + matiere.credit + ' crédits)';
                        matiereSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.disabled = true;
            matiereSelect.innerHTML = '<option value="">Sélectionner d\'abord un semestre</option>';
        }
    });

    // 3. Étudiants par matière (année active)
    matiereSelect.addEventListener('change', function() {
        const matiereId = this.value;
        resetSelects(['etudiant_select']);

        if (matiereId) {
            etudiantSelect.disabled = false;
            etudiantSelect.innerHTML = '<option value="">Chargement...</option>';

            fetch(`/get-etudiants-by-matiere?matiere_id=${matiereId}&annee_academique_id=${anneeSelect.value}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.length) {
                        etudiantSelect.innerHTML = '<option value="">Aucun étudiant inscrit pour ce niveau</option>';
                        return;
                    }
                    etudiantSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
                    data.forEach(etudiant => {
                        const option = document.createElement('option');
                        option.value = etudiant.id;
                        option.textContent = etudiant.nom_complet + ' (' + etudiant.matricule + ')';
                        etudiantSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    etudiantSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            etudiantSelect.disabled = true;
            etudiantSelect.innerHTML = '<option value="">Sélectionner d\'abord une matière</option>';
        }
    });

    // 4. Inscription de l'étudiant
    etudiantSelect.addEventListener('change', function() {
        const etudiantId = this.value;

        if (etudiantId) {
            fetch(`/get-inscription?etudiant_id=${etudiantId}&annee_academique_id=${anneeSelect.value}`)
                .then(response => response.json())
                .then(data => {
                    inscriptionId.value = (data && data.id) ? data.id : '';
                })
                .catch(() => {
                    inscriptionId.value = '';
                });
        }
    });

    // 5. Moyenne en temps réel
    function calculateMoyenne() {
        const cc = parseFloat(noteCc.value) || 0;
        const examen = parseFloat(noteExamen.value) || 0;

        if (cc >= 0 && cc <= 20 && examen >= 0 && examen <= 20) {
            const moyenne = (cc * 0.3) + (examen * 0.7);
            moyenneAffichage.textContent = moyenne.toFixed(2) + '/20';
            moyenneAffichage.style.color = moyenne >= 10 ? '#16a34a' : '#dc2626';
        } else {
            moyenneAffichage.textContent = '-';
        }
    }
    noteCc.addEventListener('input', calculateMoyenne);
    noteExamen.addEventListener('input', calculateMoyenne);

    // 6. Spinner au clic sur "Enregistrer"
    document.getElementById('noteForm').addEventListener('submit', function () {
        document.getElementById('noteSubmitBtn').disabled = true;
        document.getElementById('noteSubmitSpinner').classList.remove('hidden');
        document.getElementById('noteSubmitIcon').classList.add('hidden');
    });

    // 7. Pré-sélection si retour depuis une soumission avec erreurs
    if (specialiteSelect.value) {
        specialiteSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/notes/create.blade.php ENDPATH**/ ?>