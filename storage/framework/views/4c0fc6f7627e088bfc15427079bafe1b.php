<?php $__env->startSection('title', 'Nouvelle matière - EduManager'); ?>

<?php
    $pageTitle = 'Nouvelle matière';
    $pageSub = 'Ajouter une matière à une UE';
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

        <form action="<?php echo e(route('matieres.store')); ?>" method="POST" class="space-y-4" id="matiereForm">
            <?php echo csrf_field(); ?>

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

            <!-- Niveau (dynamique) -->
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
                    <option value="">Sélectionner d'abord un département</option>
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

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['semestre_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">Sélectionner d'abord un niveau</option>
                </select>
                <?php $__errorArgs = ['semestre_id'];
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

            <!-- UE (dynamique) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Unité d'enseignement *</label>
                <select name="unite_enseignement_id" id="ue_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['unite_enseignement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">Sélectionner d'abord un niveau</option>
                </select>
                <?php $__errorArgs = ['unite_enseignement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-xs text-slate-400 mt-1" id="ue_credit_info">
                    <i class="fa-solid fa-info-circle"></i> Le total des crédits des matières ne doit pas dépasser le crédit total de l'UE
                </p>
            </div>

            <!-- Enseignant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Enseignant</label>
                <select name="personnel_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['personnel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Sélectionner un enseignant</option>
                    <?php $__currentLoopData = $personnels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personnel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($personnel->id); ?>" <?php echo e(old('personnel_id') == $personnel->id ? 'selected' : ''); ?>>
                            <?php echo e($personnel->nom_complet); ?> (<?php echo e($personnel->matricule); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['personnel_id'];
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

            <!-- Code et Crédits -->
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Code *</label>
                    <input type="text" name="code" value="<?php echo e(old('code')); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Ex: INF-101" required>
                    <?php $__errorArgs = ['code'];
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
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Crédits *</label>
                    <input type="number" name="credit" id="credit_input" value="<?php echo e(old('credit')); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Ex: 3" min="1" max="60" required>
                    <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-xs text-slate-400 mt-1" id="credit_validation_message"></p>
                </div>
            </div>

            <!-- Libellé -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="<?php echo e(old('libelle')); ?>"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Ex: Programmation Web" required>
                <?php $__errorArgs = ['libelle'];
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

            <!-- Statut -->
            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           <?php echo e(old('est_actif', true) ? 'checked' : ''); ?>

                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Matière active</span>
                </label>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="<?php echo e(route('matieres.index')); ?>"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departementSelect = document.getElementById('departement_select');
    const niveauSelect = document.getElementById('niveau_select');
    const semestreSelect = document.getElementById('semestre_select');
    const ueSelect = document.getElementById('ue_select');
    const creditInput = document.getElementById('credit_input');
    const creditValidationMsg = document.getElementById('credit_validation_message');
    const ueCreditInfo = document.getElementById('ue_credit_info');

    let ueTotalCredit = 0;

    // ============================================
    // 1. Charger les niveaux par département
    // ============================================
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        
        resetAllSelects();
        
        if (departementId) {
            niveauSelect.disabled = false;
            niveauSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-niveaux-by-departement?departement_id=${departementId}`)
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
                            option.textContent = niveau.display_name;
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
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        }
    });

    // ============================================
    // 2. Charger les semestres et UE par niveau
    // ============================================
    niveauSelect.addEventListener('change', function() {
        const niveauId = this.value;
        
        semestreSelect.disabled = true;
        ueSelect.disabled = true;
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        if (niveauId) {
            // Charger les semestres
            semestreSelect.disabled = false;
            semestreSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-semestres-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>';
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucun semestre disponible pour ce niveau';
                        option.disabled = true;
                        semestreSelect.appendChild(option);
                    } else {
                        data.forEach(semestre => {
                            const option = document.createElement('option');
                            option.value = semestre.id;
                            option.textContent = semestre.libelle;
                            semestreSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    semestreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des semestres', 'error');
                });
            
            // Charger les UE
            ueSelect.disabled = false;
            ueSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-ues-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    ueSelect.innerHTML = '<option value="">Sélectionner une UE</option>';
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucune UE disponible pour ce niveau';
                        option.disabled = true;
                        ueSelect.appendChild(option);
                    } else {
                        data.forEach(ue => {
                            const option = document.createElement('option');
                            option.value = ue.id;
                            option.textContent = `${ue.libelle} (${ue.total_credit} crédits)`;
                            ueSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    ueSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des UE', 'error');
                });
        }
    });

    // ============================================
    // 3. Mettre à jour les informations de l'UE
    // ============================================
    ueSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const text = selectedOption.textContent;
        const match = text.match(/\((\d+)\s*crédits\)/);
        
        if (match) {
            ueTotalCredit = parseInt(match[1]);
            ueCreditInfo.innerHTML = `
                <i class="fa-solid fa-info-circle"></i> 
                Total crédits UE: <strong>${ueTotalCredit}</strong> | 
                Crédit de la matière: <span id="current_credit_display">0</span>
            `;
            validateCredit();
        } else {
            ueTotalCredit = 0;
            ueCreditInfo.innerHTML = `
                <i class="fa-solid fa-info-circle"></i> 
                Le total des crédits des matières ne doit pas dépasser le crédit total de l'UE
            `;
        }
    });

    // ============================================
    // 4. Valider les crédits en temps réel
    // ============================================
    creditInput.addEventListener('input', validateCredit);

    function validateCredit() {
        const credit = parseInt(creditInput.value) || 0;
        const currentCreditDisplay = document.getElementById('current_credit_display');
        
        if (currentCreditDisplay) {
            currentCreditDisplay.textContent = credit;
        }
        
        if (ueTotalCredit > 0 && credit > ueTotalCredit) {
            creditValidationMsg.innerHTML = `
                <span class="text-red-500">
                    ⚠️ Le crédit (${credit}) dépasse le total de l'UE (${ueTotalCredit})
                </span>
            `;
            creditInput.classList.add('border-red-500');
        } else if (ueTotalCredit > 0) {
            creditValidationMsg.innerHTML = `
                <span class="text-green-600">
                    ✓ Crédit valide (max: ${ueTotalCredit})
                </span>
            `;
            creditInput.classList.remove('border-red-500');
        } else {
            creditValidationMsg.innerHTML = '';
            creditInput.classList.remove('border-red-500');
        }
    }

    // ============================================
    // 5. Réinitialiser tous les selects
    // ============================================
    function resetAllSelects() {
        niveauSelect.disabled = true;
        semestreSelect.disabled = true;
        ueSelect.disabled = true;
        
        niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        ueTotalCredit = 0;
        creditValidationMsg.innerHTML = '';
        creditInput.classList.remove('border-red-500');
    }

    // ============================================
    // 6. Si un département est pré-sélectionné (erreur de validation)
    // ============================================
    if (departementSelect.value) {
        departementSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/etablissement/matieres/create.blade.php ENDPATH**/ ?>