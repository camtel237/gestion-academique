{{-- resources/views/etablissement/personnels/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails employé - EduManager')

@php
    $pageTitle = 'Détails employé';
    $pageSub = 'Informations complètes du personnel';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full {{ $personnel->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600' }} text-white flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($personnel->prenom, 0, 1)) }}{{ strtoupper(substr($personnel->nom, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $personnel->prenom }} {{ $personnel->nom }}</h3>
                        <p class="text-sm text-slate-500">{{ $personnel->matricule }} • {{ $personnel->fonction }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $personnel->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ $personnel->est_actif ? 'Actif' : 'Inactif' }}
                    </span>
                    @if($personnel->user_id)
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700">
                            <i class="fa-solid fa-user-check"></i> Compte
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Matricule</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->matricule }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sexe</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->sexe === 'M' ? 'Masculin' : 'Féminin' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date de naissance</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->date_naissance?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lieu de naissance</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->lieu_naissance ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->email ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Téléphone</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->telephone ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Fonction</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->fonction }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date d'embauche</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->date_embauche?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Diplôme</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->diplome ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Adresse</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $personnel->adresse ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Compte utilisateur</label>
                    @if($personnel->user_id)
                        <p class="text-slate-800 font-medium mt-1">
                            <span class="text-green-600"><i class="fa-solid fa-check-circle"></i> Compte lié</span>
                            <span class="text-sm text-slate-500 ml-2">({{ $personnel->user->email ?? '' }})</span>
                        </p>
                    @else
                        <p class="text-slate-800 font-medium mt-1">
                            <span class="text-amber-600"><i class="fa-solid fa-circle-exclamation"></i> Aucun compte</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('personnels.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
           
           
           
        </div>
    </div>
</div>
@endsection