{{-- resources/views/effets/releves/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Aperçu du relevé - EduManager')

@php
    $pageTitle = 'Aperçu du relevé de notes';
    $pageSub = $inscription->etudiant->prenom . ' ' . $inscription->etudiant->nom;
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-end gap-2 mb-4">
        <a href="{{ route('effectifs.index') }}"
           class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition bg-white">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour
        </a>
        <a href="{{ route('releves.download', $inscription->id) }}"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-download mr-1"></i> Télécharger le PDF
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="height: 80vh;">
        <iframe src="{{ route('releves.preview', $inscription->id) }}" class="w-full h-full" style="border:none;"></iframe>
    </div>
</div>
@endsection