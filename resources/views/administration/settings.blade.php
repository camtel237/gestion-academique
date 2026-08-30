{{-- resources/views/administration/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Paramètres - EduManager')

@php
    $pageTitle = 'Paramètres';
    $pageSub = "Informations générales de l'établissement et profil personnel";
@endphp

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- ============================================ --}}
    {{-- CARTE : MON PROFIL --}}
    {{-- ============================================ --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user text-brand-600"></i> Mon profil
        </h2>

        @if(session('success_profile'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success_profile') }}
            </div>
        @endif

        @if($errors->profile->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->profile->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4" id="profileForm">
            @csrf
            @method('PATCH')

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nom</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('name', 'profile') border-red-500 @enderror">
                @error('name', 'profile')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('email', 'profile') border-red-500 @enderror">
                @error('email', 'profile')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 border-t border-slate-100">
                <p class="text-xs text-slate-500 mb-3">Laissez les champs ci-dessous vides pour ne pas changer votre mot de passe.</p>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Mot de passe actuel</label>
                        <input type="password" name="current_password" autocomplete="current-password"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('current_password', 'profile') border-red-500 @enderror">
                        @error('current_password', 'profile')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nouveau mot de passe</label>
                            <input type="password" name="password" autocomplete="new-password"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('password', 'profile') border-red-500 @enderror">
                            @error('password', 'profile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" id="profileSubmitBtn"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition flex items-center gap-2">
                    <span id="profileSpinner" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i></span>
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer le profil
                </button>
            </div>
        </form>
    </div>

    {{-- ============================================ --}}
    {{-- CARTE : INFORMATIONS DE L'ÉTABLISSEMENT --}}
    {{-- ============================================ --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-building-columns text-brand-600"></i> Informations de l'établissement
        </h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->default->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ $errors->default->first() }}
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

document.getElementById('profileForm').addEventListener('submit', function () {
    document.getElementById('profileSubmitBtn').disabled = true;
    document.getElementById('profileSpinner').classList.remove('hidden');
});
</script>
@endsection