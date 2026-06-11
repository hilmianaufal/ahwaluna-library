<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ahwaluna Library</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-lime-50 text-slate-900">
<div class="min-h-screen pb-24 md:pb-0">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-lime-300/40 blur-3xl"></div>
        <div class="absolute top-40 -left-24 h-80 w-80 rounded-full bg-emerald-300/35 blur-3xl"></div>
        <div class="absolute bottom-0 right-10 h-80 w-80 rounded-full bg-green-200/50 blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/60 bg-white/85 backdrop-blur-xl md:hidden">
        <div class="flex items-center justify-between px-5 py-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl bg-white shadow-lg">
                    <img src="{{ asset('logo-ahwaluna.png') }}"
                        alt="Ahwaluna"
                        class="h-full w-full object-contain">
                </div>
                <div>
                    <h1 class="text-base font-black leading-tight text-slate-900">Ahwaluna</h1>
                    <p class="text-xs font-bold text-emerald-600">Library App</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-50 text-red-500">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                </button>
            </form>
        </div>
    </header>

    <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-white/70 bg-white/80 backdrop-blur-xl md:block">
        <div class="flex h-full flex-col p-5">

            <a href="{{ route('dashboard') }}" class="mb-6 flex items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl bg-white shadow-lg">
                    <img src="{{ asset('logo-ahwaluna.png') }}"
                        alt="Ahwaluna"
                        class="h-full w-full object-contain">
                </div>
                <div>
                    <h1 class="text-lg font-black text-slate-900">Ahwaluna</h1>
                    <p class="text-xs font-bold text-emerald-600">Ma'had Aly Library</p>
                </div>
            </a>

            <nav class="flex-1 space-y-2 overflow-y-auto pr-1 pb-4">

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('books.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('books.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="book-open" class="h-5 w-5"></i>
                    Data Buku
                </a>

                <a href="{{ route('categories.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="tags" class="h-5 w-5"></i>
                    Kategori
                </a>

                <a href="{{ route('shelves.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('shelves.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="archive" class="h-5 w-5"></i>
                    Rak Buku
                </a>

                <a href="{{ route('members.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="users" class="h-5 w-5"></i>
                    Anggota
                </a>

                <a href="{{ route('loans.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('loans.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="repeat" class="h-5 w-5"></i>
                    Peminjaman
                </a>

                <a href="{{ route('repositories.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('repositories.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                    Repository
                </a>

                <a href="{{ route('reports.loans') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                   {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="bar-chart-3" class="h-5 w-5"></i>
                    Laporan
                </a>

                <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold transition
                {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-600 hover:bg-lime-100 hover:text-emerald-700' }}">
                    <i data-lucide="shield-user" class="h-5 w-5"></i>
                    Users
                </a>
            </nav>

            <div class="mt-4 rounded-3xl bg-lime-100 p-4">
                <p class="text-xs font-bold text-slate-500">Login sebagai</p>
                <p class="mt-1 truncate text-sm font-black text-slate-800">
                    {{ Auth::user()->name }}
                </p>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-extrabold text-red-500">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </aside>

    <main class="mx-auto max-w-7xl px-5 py-6 md:ml-72 md:px-8">
        {{ $slot }}
    </main>

    <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/70 bg-white/95 px-3 py-3 backdrop-blur-xl md:hidden">
        <div class="grid grid-cols-5 gap-1">

            <a href="{{ route('dashboard') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('dashboard') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="home" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Home</span>
            </a>

            <a href="{{ route('books.index') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('books.*') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="book-open" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Buku</span>
            </a>

            <a href="{{ route('loans.create') }}"
               class="flex flex-col items-center gap-1 rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 px-2 py-2 text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="plus" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Pinjam</span>
            </a>

            <a href="{{ route('members.index') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('members.*') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="users" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Anggota</span>
            </a>

            <a href="{{ route('reports.loans') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('reports.*') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="bar-chart-3" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Laporan</span>
            </a>

        </div>
    </nav>

</div>
</body>
</html>
