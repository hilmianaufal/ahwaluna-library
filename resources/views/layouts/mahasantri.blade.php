<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasantri - Ahwaluna</title>
    <link rel="icon" href="{{ asset('logo-ahwaluna.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-lime-50 text-slate-900">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-lime-300/40 blur-3xl"></div>
        <div class="absolute -left-24 top-56 h-80 w-80 rounded-full bg-emerald-300/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-10 h-80 w-80 rounded-full bg-green-200/50 blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/70 bg-white/85 backdrop-blur-xl">
        <div class="mx-auto flex max-w-md items-center justify-between px-5 py-4">
            <a href="{{ route('mahasantri.dashboard') }}" class="flex items-center gap-3">
                <div class="h-11 w-11 overflow-hidden rounded-2xl bg-white shadow-lg">
                    <img src="{{ asset('logo-ahwaluna.png') }}"
                         class="h-full w-full object-contain"
                         alt="Ahwaluna">
                </div>

                <div>
                    <h1 class="text-base font-black leading-tight text-slate-900">
                        Ahwaluna
                    </h1>
                    <p class="text-[10px] font-black tracking-[0.22em] text-emerald-600">
                        MAHASANTRI
                    </p>
                </div>
            </a>

            <a href="{{ route('mahasantri.card') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-lime-100 text-emerald-700">
                <i data-lucide="id-card" class="h-5 w-5"></i>
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-md px-5 py-6 pb-28">
        {{ $slot }}
    </main>

    <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/70 bg-white/95 px-4 py-3 backdrop-blur-xl">
        <div class="mx-auto grid max-w-md grid-cols-5 gap-1">

            <a href="{{ route('mahasantri.dashboard') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('mahasantri.dashboard') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="home" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Home</span>
            </a>

            <a href="{{ route('mahasantri.catalog') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('mahasantri.catalog') || request()->routeIs('mahasantri.books.*') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="book-open" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Katalog</span>
            </a>


            <a href="{{ route('mahasantri.repositories') }}"
               class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2
               {{ request()->routeIs('mahasantri.repositories') ? 'bg-lime-100 text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                <span class="text-[10px] font-black">Repo</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex w-full flex-col items-center gap-1 rounded-2xl px-2 py-2 text-red-500">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    <span class="text-[10px] font-black">Logout</span>
                </button>
            </form>

        </div>
    </nav>

</body>
</html>
