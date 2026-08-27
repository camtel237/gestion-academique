{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Tableau de bord - EduManager')

@php
    $pageTitle = 'Tableau de bord';
    $pageSub = 'Vue d\'ensemble de votre établissement' . ($anneeActive ? ' — ' . $anneeActive->libelle : '');
@endphp

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Étudiants inscrits</p>                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['etudiants'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl grad-blue flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Personnel</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['personnels'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Départements</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['departements'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-building-columns"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Taux de réussite</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['taux_reussite'] }}%</p>
                <p class="text-xs mt-2 text-slate-400">
                    {{ $anneeActive->libelle ?? 'Aucune année active' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-5 mb-5">
    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Actions rapides</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <a href="{{ route('inscriptions.create') }}" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-user-plus text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Inscrire étudiant</p>
            </a>
            <a href="{{ route('notes.index') }}" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-pen-to-square text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Saisir notes</p>
            </a>
            <a href="{{ route('effectifs.index') }}" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-file-pdf text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Générer relevé</p>
            </a>
            <a href="{{ route('effectifs.index') }}" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-id-card text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Imprimer carte</p>
            </a>
            <a href="#chart-inscriptions" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-chart-pie text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Voir stats</p>
            </a>
            <a href="{{ route('users.index') }}" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-user-shield text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Utilisateurs</p>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Dernières activités</h3>
        <ul class="space-y-3 text-sm">
            @forelse($activites as $activite)
                <li class="flex gap-3 items-start">
                    <div class="w-9 h-9 rounded-lg bg-{{ $activite->color }}-100 text-{{ $activite->color }}-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $activite->icon }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-slate-700">{{ $activite->texte }}</p>
                        <p class="text-xs text-slate-400">{{ $activite->date->diffForHumans() }}</p>
                    </div>
                </li>
            @empty
                <li class="text-slate-400 text-sm">Aucune activité récente.</li>
            @endforelse
        </ul>
    </div>
</div>

<div id="chart-inscriptions" class="bg-white rounded-2xl p-5 border border-slate-100">
    <h3 class="font-bold text-slate-800 mb-4">Inscriptions par mois — {{ $anneeActive->libelle ?? 'Aucune année active' }}</h3>
    <canvas id="inscriptionsChart" height="90"></canvas>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('inscriptionsChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Inscriptions',
                data: @json($inscriptionsParMois),
                backgroundColor: '#1a365d',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
});
</script>
@endpush
@endsection