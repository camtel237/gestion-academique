{{-- resources/views/notes/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détail de la note - EduManager')

@php
    $pageTitle = 'Détail de la note';
    $pageSub = $note->etudiant->nom_complet ?? '-';
@endphp

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    <div class="flex justify-end gap-2">
        <a href="{{ route('notes.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour
        </a>
        <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-pen mr-1"></i> Modifier
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">{{ $note->etudiant->nom_complet ?? '-' }}</h2>
                <p class="text-sm text-slate-500">{{ $note->etudiant->matricule ?? '-' }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $note->est_valide ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $note->est_valide ? 'Validé' : 'Non validé' }}
            </span>
        </div>

        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm border-t border-slate-100 pt-5">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Matière</p>
                <p class="text-slate-700 mt-0.5">{{ $note->matiere->libelle ?? '-' }} ({{ $note->matiere->code ?? '-' }})</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">UE</p>
                <p class="text-slate-700 mt-0.5">{{ $note->matiere->uniteEnseignement->libelle ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Semestre</p>
                <p class="text-slate-700 mt-0.5">{{ $note->semestre->libelle ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Année académique</p>
                <p class="text-slate-700 mt-0.5">{{ $note->inscription->anneeAcademique->libelle ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6 pt-5 border-t border-slate-100">
            <div class="bg-slate-50 rounded-xl p-4 text-center">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">CC (30%)</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($note->note_cc, 2) }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 text-center">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Examen (70%)</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($note->note_examen, 2) }}</p>
            </div>
            <div class="bg-brand-50 rounded-xl p-4 text-center">
                <p class="text-xs uppercase tracking-wider text-brand-500 font-semibold">Moyenne</p>
                <p class="text-2xl font-bold {{ $note->moyenne >= 10 ? 'text-green-600' : 'text-red-600' }} mt-1">{{ number_format($note->moyenne, 2) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection