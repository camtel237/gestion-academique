<?php $__env->startSection('title', 'Nouvelle matière - EduManager'); ?>

<?php $pageTitle = 'Nouvelle matière'; $pageSub = 'Ajouter une matière à une UE'; ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto"> 
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">

        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <ul class="list-disc list-inside space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('matieres.store')); ?>" method="POST" class="space-y-3">
            <?php echo csrf_field(); ?>

            <!-- Département -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['departement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <option value="">Sélectionner</option>
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
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Niveau -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['niveau_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">D'abord un département</option>
                </select>
                <?php $__errorArgs = ['niveau_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Semestre -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['semestre_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">D'abord un niveau</option>
                </select>
                <?php $__errorArgs = ['semestre_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- UE -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Unité d'enseignement *</label>
                <select name="unite_enseignement_id" id="ue_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['unite_enseignement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required disabled>
                    <option value="">D'abord un semestre</option>
                </select>
                <?php $__errorArgs = ['unite_enseignement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-xs text-slate-400 mt-1" id="ue_credit_info">
                    <i class="fa-solid fa-info-circle"></i> Crédit UE : <span id="ue_credit_display">-</span>
                </p>
            </div>

            <!-- Enseignant -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Enseignant</label>
                <select name="personnel_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['personnel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $personnels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personnel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($personnel->id); ?>" <?php echo e(old('personnel_id') == $personnel->id ? 'selected' : ''); ?>>
                            <?php echo e($personnel->nom_complet); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['personnel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Code et Crédits sur une ligne -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600">Code</label>
                    <input type="text" value="Auto" disabled
                           class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-400 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Crédits *</label>
                    <input type="number" name="credit" id="credit_input" value="<?php echo e(old('credit')); ?>"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="3" min="1" required>
                    <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-xs text-slate-400 mt-1" id="credit_validation_message"></p>
                </div>
            </div>

            <!-- Libellé -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Libellé *</label>
                <input type="text" name="libelle" value="<?php echo e(old('libelle')); ?>"
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['libelle'];
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
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Statut -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="est_actif" value="1" <?php echo e(old('est_actif', true) ? 'checked' : ''); ?>

                       class="accent-brand-600 rounded w-4 h-4">
                <span class="text-sm text-slate-600">Matière active</span>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <a href="<?php echo e(route('matieres.index')); ?>" class="px-4 py-2 border border-slate-200 rounded-lg text-sm hover:bg-slate-50 transition">Annuler</a>
                <button type="submit" class="px-5 py-2 grad-blue text-white rounded-lg text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dept = document.getElementById('departement_select');
    const niveau = document.getElementById('niveau_select');
    const semestre = document.getElementById('semestre_select');
    const ue = document.getElementById('ue_select');
    const creditInput = document.getElementById('credit_input');
    const creditMsg = document.getElementById('credit_validation_message');
    const ueCreditDisplay = document.getElementById('ue_credit_display');
    let ueTotalCredit = 0;

    function resetAll() {
        niveau.disabled = true; semestre.disabled = true; ue.disabled = true;
        niveau.innerHTML = '<option value="">D\'abord un département</option>';
        semestre.innerHTML = '<option value="">D\'abord un niveau</option>';
        ue.innerHTML = '<option value="">D\'abord un semestre</option>';
        ueTotalCredit = 0;
        ueCreditDisplay.textContent = '-';
        creditMsg.innerHTML = '';
        creditInput.classList.remove('border-red-500');
    }

    dept.addEventListener('change', function() {
        const id = this.value;
        resetAll();
        if (!id) return;
        niveau.disabled = false;
        niveau.innerHTML = '<option value="">Chargement...</option>';
        fetch(`/get-niveaux-by-departement?departement_id=${id}`)
            .then(r => r.json())
            .then(data => {
                niveau.innerHTML = '<option value="">Sélectionner un niveau</option>';
                data.forEach(n => {
                    const opt = document.createElement('option');
                    opt.value = n.id;
                    opt.textContent = n.display_name;
                    niveau.appendChild(opt);
                });
            })
            .catch(() => {
                niveau.innerHTML = '<option value="">Erreur</option>';
                toast('Erreur chargement niveaux', 'error');
            });
    });

    niveau.addEventListener('change', function() {
        const id = this.value;
        semestre.disabled = true; ue.disabled = true;
        semestre.innerHTML = '<option value="">D\'abord un niveau</option>';
        ue.innerHTML = '<option value="">D\'abord un semestre</option>';
        if (!id) return;
        semestre.disabled = false;
        semestre.innerHTML = '<option value="">Chargement...</option>';
        fetch(`/get-semestres-by-niveau?niveau_id=${id}`)
            .then(r => r.json())
            .then(data => {
                semestre.innerHTML = '<option value="">Sélectionner un semestre</option>';
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.libelle;
                    semestre.appendChild(opt);
                });
            })
            .catch(() => {
                semestre.innerHTML = '<option value="">Erreur</option>';
                toast('Erreur chargement semestres', 'error');
            });
    });

    semestre.addEventListener('change', function() {
        const semId = this.value;
        const nivId = niveau.value;
        ue.disabled = true;
        ue.innerHTML = '<option value="">D\'abord un semestre</option>';
        if (!semId || !nivId) return;
        ue.disabled = false;
        ue.innerHTML = '<option value="">Chargement...</option>';
        fetch(`/get-ues-by-niveau?niveau_id=${nivId}&semestre_id=${semId}`)
            .then(r => r.json())
            .then(data => {
                ue.innerHTML = '<option value="">Sélectionner une UE</option>';
                data.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = `${u.libelle} (${u.total_credit} crédits)`;
                    ue.appendChild(opt);
                });
                ue.disabled = false;
            })
            .catch(() => {
                ue.innerHTML = '<option value="">Erreur</option>';
                toast('Erreur chargement UE', 'error');
            });
    });

    ue.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const match = selected.textContent.match(/\((\d+)\s*crédits\)/);
        ueTotalCredit = match ? parseInt(match[1]) : 0;
        ueCreditDisplay.textContent = ueTotalCredit || '-';
        validateCredit();
    });

    creditInput.addEventListener('input', validateCredit);

    function validateCredit() {
        const val = parseInt(creditInput.value) || 0;
        if (ueTotalCredit > 0 && val > ueTotalCredit) {
            creditMsg.innerHTML = `<span class="text-red-500">⚠️ Dépasse ${ueTotalCredit}</span>`;
            creditInput.classList.add('border-red-500');
        } else if (ueTotalCredit > 0) {
            creditMsg.innerHTML = `<span class="text-green-600">✓ Max ${ueTotalCredit}</span>`;
            creditInput.classList.remove('border-red-500');
        } else {
            creditMsg.innerHTML = '';
            creditInput.classList.remove('border-red-500');
        }
    }

    // Réinitialisation en cas de changement de département
    if (dept.value) dept.dispatchEvent(new Event('change'));
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\gestion-academique\resources\views/etablissement/matieres/create.blade.php ENDPATH**/ ?>