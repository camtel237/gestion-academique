<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'EduManager — Gestion Académique')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .grad-blue {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #60a5fa 100%);
        }
        .grad-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.88);
        }
        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: #fff;
            border-radius: 0 4px 4px 0;
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 99px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-group summary {
            list-style: none;
        }
        .sidebar-group summary::-webkit-details-marker {
            display: none;
        }
        .sidebar-group .chev {
            transition: transform 0.25s ease;
        }
        .sidebar-group.open .chev {
            transform: rotate(90deg);
        }
        .sidebar-group .sidebar-group-body {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased h-full overflow-hidden">

    @auth
        <div class="h-full flex overflow-hidden">
            {{-- Navigation latérale --}}
            @include('components.sidebar')

            {{-- Zone de contenu principale --}}
            <main class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
                @include('components.header')

                <!-- Zone scrollable unique du contenu -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">
                    @if(session('success'))
                        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-800 flex items-center gap-3 shadow-sm">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg shrink-0"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-sm text-rose-800 flex items-center gap-3 shadow-sm">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg shrink-0"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>

                @include('components.footer')
            </main>
        </div>
    @else
        <div class="min-h-screen overflow-y-auto">
            @yield('content')
        </div>
    @endauth

    <!-- Toast Notifications Container -->
    <div id="toasts" class="fixed top-20 right-4 z-[100] space-y-2 w-80 max-w-[90vw] pointer-events-none"></div>

    <script>
    // Gestionnaire des groupes dépliables du Sidebar
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sidebar-group').forEach(function (group) {
            const summary = group.querySelector('summary');
            const body = group.querySelector('.sidebar-group-body');
            if (!summary || !body) return;

            const groupName = summary.querySelector('span').textContent.trim();
            const storageKey = 'sidebar-group-' + groupName;

            const saved = localStorage.getItem(storageKey);
            const shouldBeOpen = saved === null ? true : saved === 'open';

            function setOpenState(open, animate) {
                if (open) {
                    group.setAttribute('open', '');
                    group.classList.add('open');
                    body.style.maxHeight = body.scrollHeight + 'px';
                } else {
                    if (animate) {
                        body.style.maxHeight = body.scrollHeight + 'px';
                        body.offsetHeight;
                    }
                    body.style.maxHeight = '0px';
                    group.classList.remove('open');
                    setTimeout(function () {
                        if (!group.classList.contains('open')) {
                            group.removeAttribute('open');
                        }
                    }, 300);
                }
            }

            setOpenState(shouldBeOpen, false);

            summary.addEventListener('click', function (e) {
                e.preventDefault();
                const nowOpen = !group.classList.contains('open');
                setOpenState(nowOpen, true);
                localStorage.setItem(storageKey, nowOpen ? 'open' : 'closed');
            });
        });

        window.addEventListener('resize', function () {
            document.querySelectorAll('.sidebar-group.open .sidebar-group-body').forEach(function (body) {
                body.style.maxHeight = body.scrollHeight + 'px';
            });
        });
    });

    // Fonction Toasts
    function toast(message, type = 'info') {
        const colors = {
            success: 'bg-emerald-600',
            error: 'bg-rose-600',
            warning: 'bg-amber-500',
            info: 'bg-blue-600'
        };
        const icons = {
            success: 'fa-circle-check',
            error: 'fa-circle-xmark',
            warning: 'fa-triangle-exclamation',
            info: 'fa-circle-info'
        };

        const container = document.getElementById('toasts');
        const el = document.createElement('div');
        el.className = `toast ${colors[type]} text-white px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 text-sm pointer-events-auto transform transition-all duration-300 translate-y-[-10px] opacity-0`;
        el.innerHTML = `
            <i class="fa-solid ${icons[type]} text-base shrink-0"></i>
            <span class="flex-1 font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="opacity-70 hover:opacity-100 p-1">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        `;
        container.appendChild(el);
        
        requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });

        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    }
    </script>

    @stack('scripts')
    @include('components.confirm-modal')
    @include('components.toast-welcome')
    
</body>
</html>