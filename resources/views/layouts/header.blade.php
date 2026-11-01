<header class="fixed inset-x-0 top-0 z-50 bg-slate-950 text-white shadow-md">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
        <a href="{{ route('index') }}" class="text-xl font-bold tracking-wide">Diamond Group</a>
        <div class="flex items-center gap-3 text-sm font-medium sm:gap-6">
            <a href="{{ route('index') }}" class="transition hover:text-cyan-300">Home</a>
            <a href="{{ route('aboutus') }}" class="transition hover:text-cyan-300">About</a>
            <a href="{{ route('team') }}" class="transition hover:text-cyan-300">Team</a>
            <a href="{{ route('contracts') }}" class="transition hover:text-cyan-300">Contact</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="transition hover:text-cyan-300">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                    @csrf
                    <button type="submit" class="transition hover:text-cyan-300">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="transition hover:text-cyan-300">Log in</a>
            @endauth
        </div>
    </nav>
</header>
<div class="h-16" aria-hidden="true"></div>
