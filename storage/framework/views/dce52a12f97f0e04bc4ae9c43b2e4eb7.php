
<div id="confirmModal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
        <div id="confirmModalIconWrap" class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-4">
            <i class="fa-solid fa-triangle-exclamation text-xl" id="confirmModalIcon"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-lg mb-1" id="confirmModalTitle">Confirmer la suppression</h3>
        <p class="text-sm text-slate-500 mb-5" id="confirmModalMessage">Cette action est irréversible.</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                Annuler
            </button>
            <button type="button" id="confirmModalBtn"
                    class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                Supprimer
            </button>
        </div>
    </div>
</div>

<script>
let _confirmForm = null;

function askDeleteConfirm(form, message) {
    _confirmForm = form;
    resetConfirmModalStyle();
    document.getElementById('confirmModalTitle').textContent = 'Confirmer la suppression';
    document.getElementById('confirmModalMessage').textContent = message || 'Cette action est irréversible.';
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    return false; // empêche la soumission immédiate du form
}

// Confirmation de déconnexion, réutilise la même popup avec un style neutre.
function askLogoutConfirm() {
    _confirmForm = document.getElementById('logoutForm');

    const iconWrap = document.getElementById('confirmModalIconWrap');
    iconWrap.className = 'w-12 h-12 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mb-4';
    document.getElementById('confirmModalIcon').className = 'fa-solid fa-right-from-bracket text-xl';
    document.getElementById('confirmModalTitle').textContent = 'Déconnexion';
    document.getElementById('confirmModalMessage').textContent = 'Voulez-vous vraiment vous déconnecter ?';

    const btn = document.getElementById('confirmModalBtn');
    btn.textContent = 'Se déconnecter';
    btn.className = 'px-4 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition';

    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function resetConfirmModalStyle() {
    document.getElementById('confirmModalIconWrap').className = 'w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-4';
    document.getElementById('confirmModalIcon').className = 'fa-solid fa-triangle-exclamation text-xl';
    const btn = document.getElementById('confirmModalBtn');
    btn.textContent = 'Supprimer';
    btn.className = 'px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition';
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _confirmForm = null;
    resetConfirmModalStyle();
}

document.getElementById('confirmModalBtn').addEventListener('click', function () {
    if (_confirmForm) _confirmForm.submit();
    closeConfirmModal();
});
</script><?php /**PATH D:\gestion-academique\resources\views/components/deconnect-confirm.blade.php ENDPATH**/ ?>