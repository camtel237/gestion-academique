{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Liste des notes - EduManager')

@php
    $pageTitle = 'Liste des notes';
    $pageSub = 'Gestion des notes des étudiants';
@endphp

@section('content')

<form method="GET" action="{{ route('notes.index') }}" id="notesFilterForm">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
        <div class="flex flex-wrap gap-2 flex-1">
         

            <select name="annee_academique_id" onchange="this.form.submit()"
                    class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                <option value="">Année académique</option>
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ $anneeId == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->est_active ? '(active)' : '' }}
                    </option>
                @endforeach
            </select>

            <select name="specialite_id" onchange="this.form.submit()"
                    class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition"
                    {{ $specialites->isEmpty() ? 'disabled' : '' }}>
                <option value="">{{ $specialites->isEmpty() ? "Choisir une année d'abord" : 'Spécialité' }}</option>
                @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->libelle }}
                    </option>
                @endforeach
            </select>

            <select name="semestre_id" onchange="this.form.submit()"
                    class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition"
                    {{ $semestres->isEmpty() ? 'disabled' : '' }}>
                <option value="">{{ $semestres->isEmpty() ? "Aucun semestre disponible" : 'Semestre' }}</option>
                @foreach($semestres as $semestre)
                    <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                        {{ $semestre->libelle }}({{ $semestre->niveau->libelle ?? '' }})
                    </option>
                @endforeach
            </select>

            <select name="matiere_id" onchange="this.form.submit()"
                    class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition"
                    {{ $matieres->isEmpty() ? 'disabled' : '' }}>
                <option value="">{{ $matieres->isEmpty() ? "Choisir un semestre d'abord" : 'Matière' }}</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                        {{ $matiere->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
    
    </div>
</form>

{{-- Message clair quand la spécialité n'a ni niveau ni semestre --}}
@if($specialiteSansSemestre)
    <div class="mb-4 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
        Cette spécialité n'a aucun niveau (ou aucun semestre) configuré pour cette année académique.
        Créez d'abord un niveau et ses semestres avant de pouvoir saisir des notes ici.
    </div>
@endif

@if($semestreSansMatiere)
    <div class="mb-4 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
        Ce niveau n'a aucune matière configurée. Ajoutez d'abord des matières à ce niveau pour ce semestre avant de pouvoir saisir des notes.
    </div>
@endif

@if(!$pretAAfficher)
    @if(!$specialiteSansSemestre && !$semestreSansMatiere)
        <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center text-slate-400">
            <i class="fa-solid fa-table-list text-3xl mb-3"></i>
            <p>Choisissez une année, une spécialité, un semestre puis une matière pour afficher les étudiants.</p>
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Matricule</th>
                        <th class="px-4 py-3 text-left font-semibold">Étudiant</th>
                        <th class="px-4 py-3 text-center font-semibold">CC</th>
                        <th class="px-4 py-3 text-center font-semibold">Examen</th>
                        <th class="px-4 py-3 text-center font-semibold">Moyenne</th>
                        <th class="px-4 py-3 text-center font-semibold">Statut</th>
                        <th class="px-4 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($notes as $etudiant)
                    @php $note = $etudiant->note_courante; @endphp
                    <tr class="hover:bg-slate-50 transition" data-row-etudiant="{{ $etudiant->id }}">
                        <td class="px-4 py-3 text-slate-500">{{ $etudiant->matricule }}</td>
                        <td class="px-4 py-3">{{ $etudiant->nom_complet }}</td>

                        <td class="px-4 py-3 text-center cc-cell">
                            {{ $note ? number_format($note->note_cc, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3 text-center examen-cell">
                            {{ $note ? number_format($note->note_examen, 2) : '-' }}
                        </td>
                       <td class="px-4 py-3 text-center font-bold moyenne-cell {{ $note ? ($note->moyenne >= 10 ? 'text-green-600' : 'text-red-600') : 'text-slate-400' }}">
                            {{ $note ? number_format($note->moyenne, 2) : '-' }}
                        </td>
                       <td class="px-4 py-3 text-center statut-cell">
                            @if($note)
                                <span class="text-xs font-semibold {{ $note->moyenne >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $note->moyenne >= 10 ? '≥ 10' : '< 10' }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                    Note manquante
                                </span>
                            @endif
</td>

                        <td class="px-4 py-3 text-right whitespace-nowrap actions-cell">
                            <button type="button"
                                    class="btn-complete px-3 py-1.5 rounded-lg bg-brand-100 text-brand-700 hover:bg-brand-200 text-xs font-semibold transition"
                                    data-etudiant-id="{{ $etudiant->id }}"
                                    data-inscription-id="{{ $etudiant->inscription_courante_id }}"
                                    data-cc="{{ $note->note_cc ?? '' }}"
                                    data-examen="{{ $note->note_examen ?? '' }}">
                                <i class="fa-solid fa-pen mr-1"></i>{{ $note ? 'Modifier' : 'Compléter' }}
                            </button>

                            @if($note)
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="askDeleteConfirm(this.closest('form'), 'Supprimer la note de {{ $etudiant->prenom }} {{ $etudiant->nom }} ?')"
                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition"
                                            title="Supprimer la note">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-500">
                            <i class="fa-solid fa-user-slash text-4xl text-slate-300 mb-2 block"></i>
                            Aucun étudiant inscrit pour ce niveau sur cette année académique.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $notes->links() }}</div>
@endif

{{-- Petite popup d'édition rapide CC / Examen --}}
<div id="completeModal" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Note de l'étudiant</h3>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">CC (30%)</label>
                <input type="number" id="modal_cc" min="0" max="20" step="0.5"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Examen (70%)</label>
                <input type="number" id="modal_examen" min="0" max="20" step="0.5"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
            </div>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" id="modal_cancel" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                Annuler
            </button>
            <button type="button" id="modal_save" class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                <span id="modal_spinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                Enregistrer
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('completeModal');
    const modalCc = document.getElementById('modal_cc');
    const modalExamen = document.getElementById('modal_examen');
    const modalSave = document.getElementById('modal_save');
    const modalSpinner = document.getElementById('modal_spinner');
    const modalCancel = document.getElementById('modal_cancel');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const matiereId = new URLSearchParams(window.location.search).get('matiere_id');
    const semestreId = new URLSearchParams(window.location.search).get('semestre_id');

    let currentRow = null;
    let currentEtudiantId = null;
    let currentInscriptionId = null;

    document.querySelectorAll('.btn-complete').forEach(btn => {
        btn.addEventListener('click', function () {
            currentRow = this.closest('tr');
            currentEtudiantId = this.dataset.etudiantId;
            currentInscriptionId = this.dataset.inscriptionId;

            if (!currentInscriptionId) {
                alert("Cet étudiant n'a pas d'inscription validée pour ce niveau, impossible d'enregistrer une note.");
                return;
            }

            modalCc.value = this.dataset.cc || '';
            modalExamen.value = this.dataset.examen || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    modalCancel.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

    modalSave.addEventListener('click', function () {
        if (modalCc.value === '' || modalExamen.value === '') {
            alert('Veuillez saisir la note de CC et la note Examen.');
            return;
        }

        modalSave.disabled = true;
        modalSpinner.classList.remove('hidden');

        fetch(`{{ route('notes.store') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                etudiant_id: currentEtudiantId,
                inscription_id: currentInscriptionId,
                matiere_id: matiereId,
                semestre_id: semestreId,
                note_cc: modalCc.value,
                note_examen: modalExamen.value,
            }),
        })
            .then(r => r.json())
            .then(data => {
                modalSave.disabled = false;
                modalSpinner.classList.add('hidden');
                if (data.success) {
                    closeModal();
                    // Recharge la page pour refléter la note à jour dans le tableau
                    window.location.reload();
                } else {
                    alert(data.message || "Erreur lors de l'enregistrement.");
                }
            })
            .catch(() => {
                modalSave.disabled = false;
                modalSpinner.classList.add('hidden');
                alert("Erreur lors de l'enregistrement.");
            });
    });
});
</script>
@endpush
@endsection