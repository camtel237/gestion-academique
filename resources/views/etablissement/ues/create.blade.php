{{-- resources/views/etablissement/ues/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouvelle UE - EduManager')

@php
    $pageTitle = 'Nouvelle unité d\'enseignement';
    $pageSub = 'Ajouter une UE à un semestre';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <p class="font-semibold mb-1">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('ues.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Année académique --}}
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique *</label>
                    <select id="annee_select"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition" required>
                        <option value="">Sélectionner une année</option>
                        @foreach($anneesAcademiques as $annee)
                            <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Niveau --}}
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                    <select id="niveau_select"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition" required disabled>
                        <option value="">Sélectionner d'abord une année</option>
                    </select>
                </div>

                {{-- Semestre --}}
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                    <select name="semestre_id" id="semestre_select"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('semestre_id') border-red-500 @enderror"
                            required disabled>
                        <option value="">Sélectionner d'abord un niveau</option>
                    </select>
                    @error('semestre_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Position sur le relevé --}}
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Position sur le relevé</label>
                    <input type="number" name="position_releve" value="{{ old('position_releve') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('position_releve') border-red-500 @enderror"
                           placeholder="Ex: 1" min="1">
                    @error('position_releve') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Total crédits --}}
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Total crédits *</label>
                    <input type="number" name="total_credit" value="{{ old('total_credit') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('total_credit') border-red-500 @enderror"
                           placeholder="Ex: 6" min="1" max="60" required>
                    @error('total_credit') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-slate-400 mt-1">
                        <i class="fa-solid fa-info-circle"></i> Le code de l'UE sera généré automatiquement (ex: UE001)
                    </p>
                </div>

                {{-- Libellé --}}
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                    <input type="text" name="libelle" value="{{ old('libelle') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                           placeholder="Ex: Programmation Web">
                    @error('libelle') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('ues.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit" class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const anneeSelect = document.getElementById('annee_select');
const niveauSelect = document.getElementById('niveau_select');
const semestreSelect = document.getElementById('semestre_select');

anneeSelect.addEventListener('change', function () {
    semestreSelect.disabled = true;
    semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
    if (!this.value) {
        niveauSelect.disabled = true;
        niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une année</option>';
        return;
    }
    niveauSelect.disabled = false;
    niveauSelect.innerHTML = '<option value="">Chargement...</option>';
    fetch(`{{ route('get.niveaux.by.annee.ue') }}?annee_academique_id=${this.value}`)
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) { niveauSelect.innerHTML = '<option value="">Aucun niveau pour cette année</option>'; return; }
            niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
            data.forEach(n => {
                const opt = document.createElement('option');
                opt.value = n.id; opt.textContent = n.display_full;
                niveauSelect.appendChild(opt);
            });
        });
});

niveauSelect.addEventListener('change', function () {
    if (!this.value) {
        semestreSelect.disabled = true;
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        return;
    }
    semestreSelect.disabled = false;
    semestreSelect.innerHTML = '<option value="">Chargement...</option>';
    fetch(`{{ route('get.semestres.by.niveau.ue') }}?niveau_id=${this.value}`)
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) { semestreSelect.innerHTML = '<option value="">Aucun semestre pour ce niveau</option>'; return; }
            semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>';
            data.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id; opt.textContent = s.libelle;
                semestreSelect.appendChild(opt);
            });
        });
});
</script>
@endpush
@endsection