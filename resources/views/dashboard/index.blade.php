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
{{-- ============================================ --}}
{{-- NOUVEAUX GRAPHIQUES --}}
{{-- ============================================ --}}
<div class="grid lg:grid-cols-2 gap-5 mt-5">

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Étudiants par département — {{ $anneeActive->libelle ?? 'Aucune année active' }}</h3>
        <canvas id="departementChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Taux de réussite par département (%)</h3>
        <canvas id="reussiteDepartementChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Évolution du taux de réussite (%)</h3>
        <canvas id="evolutionReussiteChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Répartition par pays</h3>
        <canvas id="paysChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 lg:col-span-2 max-w-sm mx-auto">
        <h3 class="font-bold text-slate-800 mb-4 text-center">Répartition par sexe</h3>
        <canvas id="sexeChart" height="200"></canvas>
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
    // Étudiants par département (donut)
    new Chart(document.getElementById('departementChart'), {
        type: 'doughnut',
        data: {
            labels: @json($etudiantsParDepartement['labels']),
            datasets: [{
                data: @json($etudiantsParDepartement['data']),
                backgroundColor: ['#1a365d', '#2563eb', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Taux de réussite par département (barres horizontales)
    new Chart(document.getElementById('reussiteDepartementChart'), {
        type: 'bar',
        data: {
            labels: @json($tauxReussiteParDepartement['labels']),
            datasets: [{
                label: 'Taux de réussite (%)',
                data: @json($tauxReussiteParDepartement['data']),
                backgroundColor: '#10b981',
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true, max: 100 } }
        }
    });

    // Évolution du taux de réussite (ligne)
    new Chart(document.getElementById('evolutionReussiteChart'), {
        type: 'line',
        data: {
            labels: @json($evolutionTauxReussite['labels']),
            datasets: [{
                label: 'Taux de réussite (%)',
                data: @json($evolutionTauxReussite['data']),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });

    // Répartition par pays (barres)
    new Chart(document.getElementById('paysChart'), {
        type: 'bar',
        data: {
            labels: @json($repartitionParPays['labels']),
            datasets: [{
                label: 'Étudiants',
                data: @json($repartitionParPays['data']),
                backgroundColor: '#0ea5e9',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Répartition par sexe (donut)
    new Chart(document.getElementById('sexeChart'), {
        type: 'doughnut',
        data: {
            labels: @json($repartitionParSexe['labels']),
            datasets: [{
                data: @json($repartitionParSexe['data']),
                backgroundColor: ['#2563eb', '#ec4899'],
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
});
</script>
@endpush
@endsection