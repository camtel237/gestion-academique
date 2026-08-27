{{-- resources/views/etablissement/matieres/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier matière - EduManager')

@php $pageTitle = 'Modifier matière'; $pageSub = 'Mettre à jour les informations'; @endphp

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('matieres.update', $matiere) }}" method="POST" class="space-y-3">
            @csrf @method('PUT')

            <!-- Département -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('departement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ old('departement_id', $matiere->departement_id) == $departement->id ? 'selected' : '' }}>
                            {{ $departement->libelle }} ({{ $departement->code }})
                        </option>
                    @endforeach
                </select>
                @error('departement_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Niveau -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('niveau_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ old('niveau_id', $matiere->niveau_id) == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->display_name }}
                        </option>
                    @endforeach
                </select>
                @error('niveau_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Semestre -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('semestre_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner</option>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}" {{ old('semestre_id', $matiere->semestre_id) == $semestre->id ? 'selected' : '' }}>
                            {{ $semestre->libelle }}
                        </option>
                    @endforeach
                </select>
                @error('semestre_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- UE -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Unité d'enseignement *</label>
                <select name="unite_enseignement_id" id="ue_select"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('unite_enseignement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner</option>
                    @foreach($ues as $ue)
                        <option value="{{ $ue->id }}" {{ old('unite_enseignement_id', $matiere->unite_enseignement_id) == $ue->id ? 'selected' : '' }}>
                            {{ $ue->libelle }} ({{ $ue->total_credit }} crédits)
                        </option>
                    @endforeach
                </select>
                @error('unite_enseignement_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-400 mt-1" id="ue_credit_info">
                    <i class="fa-solid fa-info-circle"></i> Crédit UE : <span id="ue_credit_display">-</span>
                </p>
            </div>

            <!-- Enseignant -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Enseignant</label>
                <select name="personnel_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('personnel_id') border-red-500 @enderror">
                    <option value="">Sélectionner</option>
                    @foreach($personnels as $personnel)
                        <option value="{{ $personnel->id }}" {{ old('personnel_id', $matiere->personnel_id) == $personnel->id ? 'selected' : '' }}>
                            {{ $personnel->nom_complet }}
                        </option>
                    @endforeach
                </select>
                @error('personnel_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Code et Crédits -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600">Code</label>
                    <input type="text" value="{{ $matiere->code }}" disabled
                           class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-500 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Crédits *</label>
                    <input type="number" name="credit" id="credit_input" value="{{ old('credit', $matiere->credit) }}"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('credit') border-red-500 @enderror"
                           placeholder="3" min="1" required>
                    @error('credit') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-slate-400 mt-1" id="credit_validation_message"></p>
                </div>
            </div>

            <!-- Libellé -->
            <div>
                <label class="text-xs font-semibold text-slate-600">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle', $matiere->libelle) }}"
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: Programmation Web" required>
                @error('libelle') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Statut -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="est_actif" value="1" {{ old('est_actif', $matiere->est_actif) ? 'checked' : '' }}
                       class="accent-brand-600 rounded w-4 h-4">
                <span class="text-sm text-slate-600">Matière active</span>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <a href="{{ route('matieres.index') }}" class="px-4 py-2 border border-slate-200 rounded-lg text-sm hover:bg-slate-50 transition">Annuler</a>
                <button type="submit" class="px-5 py-2 grad-blue text-white rounded-lg text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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

    // Fonctions de chargement pour l'édition (cascade avec sélections initiales)
    function loadNiveaux(departementId, selectedId) {
        if (!departementId) return;
        fetch(`/get-niveaux-by-departement?departement_id=${departementId}`)
            .then(r => r.json())
            .then(data => {
                niveau.innerHTML = '<option value="">Sélectionner un niveau</option>';
                data.forEach(n => {
                    const opt = document.createElement('option');
                    opt.value = n.id;
                    opt.textContent = n.display_name;
                    if (selectedId && n.id == selectedId) opt.selected = true;
                    niveau.appendChild(opt);
                });
                if (selectedId) {
                    loadSemestres(selectedId, "{{ old('semestre_id', $matiere->semestre_id) }}");
                }
            })
            .catch(() => toast('Erreur chargement niveaux', 'error'));
    }

    function loadSemestres(niveauId, selectedId) {
        if (!niveauId) return;
        fetch(`/get-semestres-by-niveau?niveau_id=${niveauId}`)
            .then(r => r.json())
            .then(data => {
                semestre.innerHTML = '<option value="">Sélectionner un semestre</option>';
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.libelle;
                    if (selectedId && s.id == selectedId) opt.selected = true;
                    semestre.appendChild(opt);
                });
                if (selectedId) {
                    loadUes(niveauId, "{{ old('unite_enseignement_id', $matiere->unite_enseignement_id) }}", selectedId);
                }
            })
            .catch(() => toast('Erreur chargement semestres', 'error'));
    }

    function loadUes(niveauId, selectedUeId, semestreId) {
        if (!niveauId || !semestreId) return;
        fetch(`/get-ues-by-niveau?niveau_id=${niveauId}&semestre_id=${semestreId}`)
            .then(r => r.json())
            .then(data => {
                ue.innerHTML = '<option value="">Sélectionner une UE</option>';
                data.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = `${u.libelle} (${u.total_credit} crédits)`;
                    if (selectedUeId && u.id == selectedUeId) opt.selected = true;
                    ue.appendChild(opt);
                });
                // Mettre à jour l'affichage des crédits
                if (selectedUeId) {
                    const selectedOpt = ue.querySelector(`option[value="${selectedUeId}"]`);
                    if (selectedOpt) {
                        const match = selectedOpt.textContent.match(/\((\d+)\s*crédits\)/);
                        ueTotalCredit = match ? parseInt(match[1]) : 0;
                        ueCreditDisplay.textContent = ueTotalCredit || '-';
                        validateCredit();
                    }
                }
            })
            .catch(() => toast('Erreur chargement UE', 'error'));
    }

    // Validation crédit
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

    // Événements
    dept.addEventListener('change', function() {
        const id = this.value;
        niveau.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        semestre.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ue.innerHTML = '<option value="">Sélectionner d\'abord un semestre</option>';
        if (id) loadNiveaux(id);
    });

    niveau.addEventListener('change', function() {
        const id = this.value;
        semestre.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ue.innerHTML = '<option value="">Sélectionner d\'abord un semestre</option>';
        if (id) loadSemestres(id);
    });

    semestre.addEventListener('change', function() {
        const semId = this.value;
        const nivId = niveau.value;
        ue.innerHTML = '<option value="">Sélectionner d\'abord un semestre</option>';
        if (semId && nivId) loadUes(nivId, null, semId);
    });

    ue.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const match = selected.textContent.match(/\((\d+)\s*crédits\)/);
        ueTotalCredit = match ? parseInt(match[1]) : 0;
        ueCreditDisplay.textContent = ueTotalCredit || '-';
        validateCredit();
    });

    creditInput.addEventListener('input', validateCredit);

    // Initialisation avec les valeurs existantes
    const initialDept = dept.value;
    if (initialDept) {
        loadNiveaux(initialDept, "{{ old('niveau_id', $matiere->niveau_id) }}");
    }
});
</script>
@endpush
@endsection