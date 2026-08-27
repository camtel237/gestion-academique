{{-- resources/views/etablissement/ues/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Unités d\'enseignement - EduManager')

@php
    $pageTitle = 'Unités d\'enseignement';
    $pageSub = 'Gestion des UE par niveau et année';
@endphp

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="flex flex-wrap gap-2 flex-1">
        <div class="relative max-w-sm flex-1 min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <form method="GET" action="{{ route('ues.index') }}" class="inline">
                <input type="text" name="search" placeholder="Rechercher une UE..."
                       value="{{ request('search') }}"
                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('ues.index') }}" class="inline">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="niveau_id" value="{{ request('niveau_id') }}">
                <select name="annee_academique_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les années</option>
                    @foreach($anneesAcademiques as $annee)
                        <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('ues.index') }}" class="inline">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="annee_academique_id" value="{{ request('annee_academique_id') }}">
                <select name="niveau_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Tous les niveaux</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ request('niveau_id') == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->display_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <button onclick="toast('Export Excel lancé', 'info')"
                class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="{{ route('ues.create') }}"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouvelle UE
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Code</th>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Crédits</th>
                    <th class="px-4 py-3 text-left font-semibold">Semestre</th>
                    <th class="px-4 py-3 text-left font-semibold">Niveau</th>
                    <th class="px-4 py-3 text-left font-semibold">Année</th>
                    <th class="px-4 py-3 text-left font-semibold">Matières</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($ues as $ue)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700">{{ $ue->code }}</td>
                    <td class="px-4 py-3">{{ $ue->libelle }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $ue->total_credit }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($ue->semestre)
                            <span class="px-2 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold">
                                {{ $ue->semestre->libelle }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-red-50 text-red-600 text-xs font-semibold" title="Aucun semestre assigné">
                                Non défini
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($ue->niveau)
                            {{ $ue->niveau->libelle }}
                            <span class="text-xs text-slate-400 block">
                                {{ $ue->niveau->specialite->libelle ?? 'Sans spécialité' }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $ue->anneeAcademique->libelle ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold">
                            {{ $ue->matieres->count() }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('ues.show', $ue) }}"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('ues.edit', $ue) }}"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('ues.destroy', $ue) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    onclick="askDeleteConfirm(this.closest('form'), 'Supprimer l\'UE {{ $ue->libelle }} ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition"
                                    title="Supprimer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-cubes text-4xl text-slate-300 mb-2 block"></i>
                        Aucune unité d'enseignement trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $ues->links() }}
</div>
@endsection