<?php $__env->startSection('title', 'Nouvelle inscription - EduManager'); ?>

<?php
    $pageTitle = 'Nouvelle inscription';
    $pageSub = 'Inscrire un étudiant dans une filière';
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
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

        <form action="<?php echo e(route('inscriptions.store')); ?>" method="POST" class="space-y-4" id="inscriptionForm">
            <?php echo csrf_field(); ?>

            <!-- Étudiant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Étudiant *</label>
                <select name="etudiant_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['etudiant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <option value="">Sélectionner un étudiant</option>
                    <?php $__currentLoopData = $etudiants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etudiant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($etudiant->id); ?>" <?php echo e(old('etudiant_id', request('etudiant_id')) == $etudiant->id ? 'selected' : ''); ?>>
                            <?php echo e($etudiant->nom_complet); ?> (<?php echo e($etudiant->matricule); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['etudiant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Année académique -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique *</label>
                <select name="annee_academique_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['annee_academique_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <option value="">Sélectionner une année</option>
                    <?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($annee->id); ?>" <?php echo e(old('annee_academique_id') == $annee->id ? 'selected' : ''); ?>>
                            <?php echo e($annee->libelle); ?> <?php echo e($annee->est_active ? '(Active)' : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['annee_academique_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Département -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['departement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <option value="">Sélectionner un département</option>
                    <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($departement->id); ?>" <?php echo e(old('departement_id') == $departement->id ? 'selected' : ''); ?>>
                            <?php echo e($departement->libelle); ?> (<?php echo e($departement->code); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['departement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Spécialité (dynamique selon département) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                <select name="specialite_id" id="specialite_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['specialite_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">Sélectionner d'abord un département</option>
                </select>
                <?php $__errorArgs = ['specialite_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Niveau (dynamique selon spécialité) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['niveau_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">Sélectionner d'abord une spécialité</option>
                </select>
                <?php $__errorArgs = ['niveau_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Commentaire -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Commentaire</label>
                <textarea name="commentaire" rows="3"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['commentaire'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          placeholder="Informations supplémentaires sur l'inscription..."><?php echo e(old('commentaire')); ?></textarea>
                <?php $__errorArgs = ['commentaire'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="<?php echo e(route('inscriptions.index')); ?>"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer l'inscription
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departementSelect = document.getElementById('departement_select');
    const specialiteSelect = document.getElementById('specialite_select');
    const niveauSelect = document.getElementById('niveau_select');

    // ============================================
    // 1. Charger les spécialités par département
    // ============================================
    function loadSpecialites(departementId, selectedId = null) {
        if (departementId) {
            specialiteSelect.disabled = false;
            specialiteSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-specialites-by-departement?departement_id=${departementId}`)
                .then(response => response.json())
                .then(data => {
                    specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
                    // Réinitialiser le niveau
                    niveauSelect.disabled = true;
                    niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
                    
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucune spécialité disponible';
                        option.disabled = true;
                        specialiteSelect.appendChild(option);
                    } else {
                        data.forEach(specialite => {
                            const option = document.createElement('option');
                            option.value = specialite.id;
                            option.textContent = specialite.libelle + ' (' + specialite.code + ')';
                            if (selectedId && specialite.id == selectedId) {
                                option.selected = true;
                                // Charger les niveaux si une spécialité est pré-sélectionnée
                                loadNiveaux(specialite.id, "<?php echo e(old('niveau_id')); ?>");
                            }
                            specialiteSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    specialiteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des spécialités', 'error');
                });
        } else {
            specialiteSelect.disabled = true;
            specialiteSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    }

    // ============================================
    // 2. Charger les niveaux par spécialité
    // ============================================
    function loadNiveaux(specialiteId, selectedId = null) {
        if (specialiteId) {
            niveauSelect.disabled = false;
            niveauSelect.innerHTML = '<option value="">Chargement...</option>';
            
           fetch(`<?php echo e(route('get.niveaux.by.specialite.inscription')); ?>?specialite_id=${specialiteId}`) 
                .then(response => response.json())
                .then(data => {
                    niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucun niveau disponible';
                        option.disabled = true;
                        niveauSelect.appendChild(option);
                    } else {
                        data.forEach(niveau => {
                            const option = document.createElement('option');
                            option.value = niveau.id;
                            option.textContent = niveau.libelle;
                            if (selectedId && niveau.id == selectedId) {
                                option.selected = true;
                            }
                            niveauSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    niveauSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des niveaux', 'error');
                });
        } else {
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    }

    // ============================================
    // 3. Événements
    // ============================================
    
    // Quand le département change
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        loadSpecialites(departementId);
    });

    // Quand la spécialité change
    specialiteSelect.addEventListener('change', function() {
        const specialiteId = this.value;
        loadNiveaux(specialiteId);
    });

    // ============================================
    // 4. Charger les données initiales
    // ============================================
    const initialDepartement = departementSelect.value;
    const initialSpecialite = "<?php echo e(old('specialite_id')); ?>";
    const initialNiveau = "<?php echo e(old('niveau_id')); ?>";

    if (initialDepartement) {
        loadSpecialites(initialDepartement, initialSpecialite);
    }

   
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/inscriptions/create.blade.php ENDPATH**/ ?>