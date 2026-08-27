@php
    $menus = [
        ['id' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Tableau de bord', 'route' => 'dashboard'],
        ['group' => 'Établissement', 'items' => [
            ['id' => 'annees-academiques', 'icon' => 'fa-calendar-days', 'label' => 'Années académiques', 'route' => 'annees-academiques.index'],
            ['id' => 'personnels', 'icon' => 'fa-user-tie', 'label' => 'Personnel', 'route' => 'personnels.index'],
            ['id' => 'departements', 'icon' => 'fa-building-columns', 'label' => 'Départements', 'route' => 'departements.index'],
            ['id' => 'specialites', 'icon' => 'fa-layer-group', 'label' => 'Spécialités', 'route' => 'specialites.index'],
            ['id' => 'niveaux', 'icon' => 'fa-stairs', 'label' => 'Niveaux', 'route' => 'niveaux.index'],
            ['id' => 'semestres', 'icon' => 'fa-clock', 'label' => 'Semestres', 'route' => 'semestres.index'],
            ['id' => 'ues', 'icon' => 'fa-cubes', 'label' => 'Unités d\'enseignement', 'route' => 'ues.index'],
            ['id' => 'matieres', 'icon' => 'fa-book', 'label' => 'Matières', 'route' => 'matieres.index'],
        ]],
        ['group' => 'Étudiants', 'items' => [
            ['id' => 'etudiants-list', 'icon' => 'fa-users', 'label' => 'Liste des étudiants', 'route' => 'etudiants.index'],
            ['id' => 'etudiants-add', 'icon' => 'fa-user-plus', 'label' => 'Ajouter un étudiant', 'route' => 'etudiants.create'],
            ['id' => 'inscriptions', 'icon' => 'fa-file-signature', 'label' => 'Inscriptions', 'route' => 'inscriptions.index'],
        ]],
        ['group' => 'Notes', 'items' => [
            ['id' => 'notes-list', 'icon' => 'fa-list-check', 'label' => 'Liste des notes', 'route' => 'notes.index'],
        ]],
       
            ['group' => 'Effets Académiques', 'items' => [
            ['id' => 'effectifs', 'icon' => 'fa-users', 'label' => 'Générer effets', 'route' => 'effectifs.index'],
        ]],
        ['group' => 'Administration', 'items' => [
            ['id' => 'users', 'icon' => 'fa-users-gear', 'label' => 'Utilisateurs', 'route' => 'users.index'],
            ['id' => 'settings', 'icon' => 'fa-sliders', 'label' => 'Paramètres', 'route' => 'settings.index'],
        ]],
    ];
    $currentRoute = request()->route()->getName() ?? 'dashboard';
@endphp

<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 h-screen grad-card text-white -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl shrink-0">
    <!-- Logo Header -->
    <div class="p-5 border-b border-white/10 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center shadow-inner">
                <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-none tracking-tight">EduManager</h1>
                <p class="text-[11px] text-blue-200/80 font-medium mt-1">v1.0 • Académique</p>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation Scrollable -->
    <nav class="flex-1 overflow-y-auto scrollbar-thin p-3 space-y-1 text-sm">
        @foreach($menus as $menu)
            @if(isset($menu['group']))
                <details class="sidebar-group mb-1 group" open>
                    <summary class="px-3 py-2 text-[11px] uppercase tracking-wider text-blue-200/70 font-bold flex items-center justify-between cursor-pointer hover:text-white transition rounded-md">
                        <span>{{ $menu['group'] }}</span>
                        <i class="fa-solid fa-chevron-right chev text-[10px] opacity-70"></i>
                    </summary>
                    <div class="sidebar-group-body">
                        <div class="space-y-0.5 mt-1 pl-1">
                            @foreach($menu['items'] as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition font-medium text-xs sm:text-sm {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                                    <i class="fa-solid {{ $item['icon'] }} w-5 text-center text-sm"></i>
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </details>
            @else
                <a href="{{ route($menu['route']) }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition font-medium text-xs sm:text-sm {{ $currentRoute === $menu['route'] ? 'active' : '' }}">
                    <i class="fa-solid {{ $menu['icon'] }} w-5 text-center text-sm"></i>
                    <span class="truncate">{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- User Footer -->
    <div class="p-4 border-t border-white/10 shrink-0 bg-black/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm shadow-sm shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-white text-sm font-semibold truncate leading-tight">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-[11px] text-blue-200/80 truncate mt-0.5">Administrateur</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" title="Déconnexion" class="p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition flex items-center justify-center">
                    <i class="fa-solid fa-right-from-bracket text-base"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Backdrop Mobile -->
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 lg:hidden"></div>