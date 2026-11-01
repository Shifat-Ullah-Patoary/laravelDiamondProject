<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Admin | Diamond Group')</title>
    @stack('styles')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="min-h-screen lg:flex">
        @auth
            <div id="adminOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/50 lg:hidden"></div>
            
            {{-- Sidebar changed to flex flex-col to prevent overlap issues --}}
            <aside id="adminSidebar"
                class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-slate-950 text-white transition-transform lg:translate-x-0">
                
                {{-- Logo / Brand Header (Fixed height) --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex h-20 items-center gap-3 border-b border-white/10 px-6 text-lg font-bold">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-cyan-500 text-slate-950">DG</span>
                        <span>Diamond Admin</span>
                    </a>
                </div>

                {{-- Scrollable Nav Menu Area --}}
                <div class="flex-1 overflow-y-auto py-4">
                    <p class="px-6 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-400">Main menu</p>

                    <nav class="space-y-1 px-3">
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Dashboard
                        </a>

                        {{-- Home --}}
                        <a href="{{ route('index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('index') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Home
                        </a>

                        {{-- Contract Messages --}}
                        <a href="{{ route('contractsTable') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('contractsTable') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Contract Messages
                        </a>

                        {{-- Home Page Settings --}}
                        <a href="{{ route('admin.home-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.home-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Home Page Settings
                        </a>

                        {{-- About Settings --}}
                        <a href="{{ route('admin.about-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.about-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            About Settings
                        </a>

                        {{-- Contract Settings --}}
                        <a href="{{ route('admin.contract-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.contract-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Contract Settings
                        </a>

                        {{-- Truck Detail Settings --}}
                        <a href="{{ route('admin.truckDetails-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.truckDetails-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Truck Detail Settings
                        </a>

                        {{-- Construction Detail Settings --}}
                        <a href="{{ route('admin.constructionDetails-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.constructionDetails-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Construction Detail Settings
                        </a>

                        {{-- Travel Details Settings --}}
                        <a href="{{ route('admin.travelDetails-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.travelDetails-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Travel Detail Settings
                        </a>

                        {{-- Team Settings --}}
                        <a href="{{ route('admin.team-settings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.team-settings.*') ? 'bg-cyan-500/15 font-medium text-cyan-300' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            Team Settings
                        </a>
                    </nav>
                </div>

                {{-- Footer / Logout Section (Fixed at bottom) --}}
                <div class="flex-shrink-0 border-t border-white/10 p-4">
                    <p class="mb-3 truncate px-2 text-sm text-slate-300">{{ auth()->user()->name }}</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">Log
                            out</button>
                    </form>
                </div>
            </aside>
        @endauth

        <div class="min-w-0 flex-1 @auth lg:ml-64 @endauth">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-8">
                <div class="flex items-center gap-3">
                    @auth
                        <button id="sidebarToggle" type="button" aria-label="Toggle navigation" aria-expanded="false"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-100 lg:hidden">Menu</button>
                    @endauth
                    <a href="{{ route('index') }}" class="font-semibold text-slate-900">Diamond Group</a>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Guest' }}</p>
                    <p class="text-xs text-slate-500">@auth Administrator
                        @else
                        Visitor @endauth
                    </p>
                </div>
            </header>
            <main class="mx-auto w-full max-w-7xl p-4 sm:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (sidebar && overlay && toggle) {
            const setSidebarOpen = (open) => {
                sidebar.classList.toggle('-translate-x-full', !open);
                overlay.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', String(open));
            };

            toggle.addEventListener('click', () => {
                setSidebarOpen(toggle.getAttribute('aria-expanded') !== 'true');
            });
            overlay.addEventListener('click', () => setSidebarOpen(false));
        }
    </script>
    @stack('scripts')
</body>

</html>