

<?php if(session('welcome_toast') || session('goodbye_toast')): ?>
    <div id="authToast"
         class="fixed top-5 right-5 z-[100] bg-white border border-slate-200 shadow-2xl rounded-2xl px-5 py-4 flex items-center gap-3 animate-pop"
         style="min-width: 260px;">
        <?php if(session('welcome_toast')): ?>
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">Bienvenue, <?php echo e(session('welcome_toast')); ?> !</p>
                <p class="text-xs text-slate-400">Vous êtes connecté avec succès.</p>
            </div>
        <?php else: ?>
            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">À bientôt !</p>
                <p class="text-xs text-slate-400">Vous avez été déconnecté avec succès.</p>
            </div>
        <?php endif; ?>
        <button type="button" onclick="document.getElementById('authToast').remove()"
                class="ml-2 text-slate-300 hover:text-slate-500">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <script>
        setTimeout(function () {
            const el = document.getElementById('authToast');
            if (el) {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }
        }, 4000);
    </script>
<?php endif; ?><?php /**PATH D:\gestion-academique\resources\views/components/toast-welcome.blade.php ENDPATH**/ ?>