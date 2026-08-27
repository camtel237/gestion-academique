 
<?php $__env->startSection('title', 'Modifier étudiant - EduManager'); ?>
 
<?php
    $pageTitle = 'Modifier étudiant';
    $pageSub = 'Mettre à jour les informations de l\'étudiant';
?>
 
<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="<?php echo e(route('etudiants.update', $etudiant)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
 
            <!-- Photo -->
                    <!-- Photo - CORRECTION ICI -->
            <div class="flex items-center gap-4">
                <div class="w-24 h-28 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                    <?php if($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)): ?>
                        
                        <img id="photo-preview" 
                             src="<?php echo e(asset('storage/' . $etudiant->photo)); ?>" 
                             alt="Photo de <?php echo e($etudiant->prenom); ?> <?php echo e($etudiant->nom); ?>"
                             class="w-full h-full object-cover">
                        <i id="photo-placeholder" class="fa-solid fa-user text-3xl text-slate-300 hidden"></i>
                    <?php else: ?>
                        
                        <img id="photo-preview" src="" alt="" class="hidden w-full h-full object-cover">
                        <i id="photo-placeholder" class="fa-solid fa-user text-3xl text-slate-300"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Photo de l'étudiant</label>
                    <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"
                           onchange="previewPhoto(this)"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="text-xs text-slate-400 mt-1">Laisser vide pour conserver la photo actuelle.</p>
                </div>
            </div>
 
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nom *</label>
                    <input type="text" name="nom" value="<?php echo e(old('nom', $etudiant->nom)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Prénom *</label>
                    <input type="text" name="prenom" value="<?php echo e(old('prenom', $etudiant->prenom)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
 
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Sexe *</label>
                    <select name="sexe"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['sexe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Sélectionner</option>
                        <option value="M" <?php echo e(old('sexe', $etudiant->sexe) == 'M' ? 'selected' : ''); ?>>Masculin</option>
                        <option value="F" <?php echo e(old('sexe', $etudiant->sexe) == 'F' ? 'selected' : ''); ?>>Féminin</option>
                    </select>
                    <?php $__errorArgs = ['sexe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nationalité</label>
                    <input type="text" name="nationalite" value="<?php echo e(old('nationalite', $etudiant->nationalite)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Pays *</label>
        <select name="pays"
                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['pays'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required>
            <option value="">Sélectionner un pays</option>
            <option value="Cameroun" <?php echo e(old('pays', $etudiant->pays) == 'Cameroun' ? 'selected' : ''); ?>>🇨🇲 Cameroun</option>
            <option value="Nigeria" <?php echo e(old('pays', $etudiant->pays) == 'Nigeria' ? 'selected' : ''); ?>>🇳🇬 Nigeria</option>
            <option value="Sénégal" <?php echo e(old('pays', $etudiant->pays) == 'Sénégal' ? 'selected' : ''); ?>>🇸🇳 Sénégal</option>
            <option value="Côte d'Ivoire" <?php echo e(old('pays', $etudiant->pays) == "Côte d'Ivoire" ? 'selected' : ''); ?>>🇨🇮 Côte d'Ivoire</option>
            <option value="Ghana" <?php echo e(old('pays', $etudiant->pays) == 'Ghana' ? 'selected' : ''); ?>>🇬🇭 Ghana</option>
            <option value="Kenya" <?php echo e(old('pays', $etudiant->pays) == 'Kenya' ? 'selected' : ''); ?>>🇰🇪 Kenya</option>
            <option value="Afrique du Sud" <?php echo e(old('pays', $etudiant->pays) == 'Afrique du Sud' ? 'selected' : ''); ?>>🇿🇦 Afrique du Sud</option>
            <option value="Maroc" <?php echo e(old('pays', $etudiant->pays) == 'Maroc' ? 'selected' : ''); ?>>🇲🇦 Maroc</option>
            <option value="Tunisie" <?php echo e(old('pays', $etudiant->pays) == 'Tunisie' ? 'selected' : ''); ?>>🇹🇳 Tunisie</option>
            <option value="Algérie" <?php echo e(old('pays', $etudiant->pays) == 'Algérie' ? 'selected' : ''); ?>>🇩🇿 Algérie</option>
            <option value="Égypte" <?php echo e(old('pays', $etudiant->pays) == 'Égypte' ? 'selected' : ''); ?>>🇪🇬 Égypte</option>
            <option value="République Démocratique du Congo" <?php echo e(old('pays', $etudiant->pays) == 'République Démocratique du Congo' ? 'selected' : ''); ?>>🇨🇩 RDC</option>
            <option value="Angola" <?php echo e(old('pays', $etudiant->pays) == 'Angola' ? 'selected' : ''); ?>>🇦🇴 Angola</option>
            <option value="Mali" <?php echo e(old('pays', $etudiant->pays) == 'Mali' ? 'selected' : ''); ?>>🇲🇱 Mali</option>
            <option value="Burkina Faso" <?php echo e(old('pays', $etudiant->pays) == 'Burkina Faso' ? 'selected' : ''); ?>>🇧🇫 Burkina Faso</option>
        </select>
        <?php $__errorArgs = ['pays'];
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
 
            </div>
 
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date de naissance</label>
                    <input type="date" name="date_naissance" value="<?php echo e(old('date_naissance', $etudiant->date_naissance?->format('Y-m-d'))); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="<?php echo e(old('lieu_naissance', $etudiant->lieu_naissance)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>
 
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $etudiant->email)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Téléphone</label>
                    <input type="text" name="telephone" value="<?php echo e(old('telephone', $etudiant->telephone)); ?>"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>
 
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Adresse</label>
                <textarea name="adresse" rows="2"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"><?php echo e(old('adresse', $etudiant->adresse)); ?></textarea>
            </div>
 
            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           <?php echo e(old('est_actif', $etudiant->est_actif) ? 'checked' : ''); ?>

                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Étudiant actif</span>
                </label>
            </div>
 
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="<?php echo e(route('etudiants.index')); ?>"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
 
<?php $__env->startPush('scripts'); ?>
<script>
function previewPhoto(input) {
    const preview = document.getElementById('photo-preview');
    const placeholder = document.getElementById('photo-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/etudiants/edit.blade.php ENDPATH**/ ?>