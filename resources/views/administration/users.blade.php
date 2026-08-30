{{-- resources/views/administration/users.blade.php --}}
@extends('layouts.app')

@section('title', 'Utilisateurs - EduManager')

@php
    $pageTitle = 'Utilisateurs';
    $pageSub = "Gestion des comptes utilisateurs";
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-10 text-center text-slate-400">
        <i class="fa-solid fa-users text-4xl mb-3 block"></i>
        <p class="text-slate-500 font-medium">Aucun utilisateur pour le moment.</p>
        <p class="text-sm mt-1">Cette section est en cours de développement.</p>
    </div>
</div>
@endsection