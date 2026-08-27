{{-- resources/views/etudiants/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Fiche étudiant - EduManager')

@php
    $pageTitle = 'Fiche étudiant';
    $pageSub = $etudiant->prenom . ' ' . $etudiant->nom;
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex justify-end gap-2">
        <a href="{{ route('etudiants.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour
        </a>
       
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4 mb-6">
            @if($etudiant->photo)
                <img src="{{ asset('storage/' . $etudiant->photo) }}" class="w-20 h-24 rounded-xl object-cover border border-slate-200">
            @else
                <div class="w-20 h-24 rounded-xl {{ $etudiant->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600' }} text-white flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h2>
                <p class="text-sm text-slate-500">Matricule : <span class="font-semibold text-brand-700">{{ $etudiant->matricule }}</span></p>
                <span class="inline-block mt-1 px-2 py-1 rounded-full text-xs font-semibold {{ $etudiant->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $etudiant->est_actif ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm border-t border-slate-100 pt-5">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Sexe</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->sexe === 'M' ? 'Masculin' : 'Féminin' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Date de naissance</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Lieu de naissance</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->lieu_naissance ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Email</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Téléphone</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->telephone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Adresse</p>
                <p class="text-slate-700 mt-0.5">{{ $etudiant->adresse ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Historique des inscriptions</h3>
        @forelse($etudiant->inscriptions as $inscription)
            <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                <div>
                    <p class="font-semibold text-slate-700">{{ $inscription->specialite->libelle ?? '-' }} — {{ $inscription->niveau->libelle ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $inscription->departement->libelle ?? '-' }} · {{ $inscription->anneeAcademique->libelle ?? '-' }}</p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $inscription->statut === 'validee' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ ucfirst($inscription->statut) }}
                </span>
            </div>
        @empty
            <p class="text-sm text-slate-500">Aucune inscription enregistrée.</p>
        @endforelse
    </div>
</div>
@endsection