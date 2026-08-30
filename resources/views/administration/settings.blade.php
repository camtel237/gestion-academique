{{-- resources/views/administration/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Paramètres - EduManager')

@php
    $pageTitle = 'Paramètres';
    $pageSub = "Informations générales de l'établissement";
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" class="space-y-4" id="settingsForm">
            @csrf

            @foreach($champs as $key => $label)
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">{{ $label }}</label>
                    <input type="{{ $key === 'email' ? 'email' : 'text' }}" name="{{ $key }}"
                           value="{{ old($key, $valeurs[$key]) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            @endforeach

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" id="settingsSubmitBtn"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                    <span id="settingsSpinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('settingsForm').addEventListener('submit', function () {
    document.getElementById('settingsSubmitBtn').disabled = true;
    document.getElementById('settingsSpinner').classList.remove('hidden');
});
</script>
@endsection