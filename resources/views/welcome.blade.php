<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahwaluna Library</title>
    <link rel="icon" href="{{ asset('logo-ahwaluna.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-[#f7fee7] text-slate-900">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-lime-300/40 blur-3xl"></div>
        <div class="absolute left-[-120px] top-64 h-96 w-96 rounded-full bg-emerald-300/35 blur-3xl"></div>
        <div class="absolute bottom-0 right-20 h-96 w-96 rounded-full bg-green-200/50 blur-3xl"></div>
    </div>

    {{-- NAVBAR --}}
    <nav class="fixed left-0 right-0 top-0 z-50 border-b border-white/60 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="h-12 w-12 overflow-hidden rounded-2xl bg-white shadow-lg">
                    <img src="{{ asset('logo-ahwaluna.png') }}" class="h-full w-full object-contain">
                </div>
                <div>
                    <h1 class="text-base font-black tracking-wide text-slate-900">AHWALUNA</h1>
                    <p class="text-[10px] font-black tracking-[0.25em] text-emerald-600">LIBRARY</p>
                </div>
            </a>

            <div class="hidden items-center gap-8 text-sm font-black text-slate-600 md:flex">
                <a href="#koleksi" class="hover:text-emerald-700">Koleksi</a>
                <a href="#repository" class="hover:text-emerald-700">Repository</a>
                <a href="#fitur" class="hover:text-emerald-700">Fitur</a>
            </div>

            <a href="{{ route('login') }}"
               class="rounded-2xl bg-gradient-to-r from-emerald-600 to-lime-400 px-5 py-3 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                Login
            </a>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="relative mx-auto max-w-7xl px-5 pb-16 pt-32 md:pt-40">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <div class="gsap-fade-up">
                <div class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-black text-emerald-700 shadow-lg shadow-emerald-900/5">
                    <i data-lucide="sparkles" class="h-4 w-4"></i>
                    Perpustakaan Digital Ma'had Aly
                </div>

                <h2 class="mt-6 text-4xl font-black leading-tight text-slate-950 md:text-6xl">
                    مكتبة أحوالنا
                    <span class="block bg-gradient-to-r from-emerald-700 to-lime-500 bg-clip-text text-transparent">
                        Ahwaluna Library
                    </span>
                </h2>

                <p class="mt-5 max-w-xl text-base font-semibold leading-relaxed text-slate-600">
                    Platform perpustakaan modern untuk Ma'had Aly Kebon Jambu. Kelola koleksi kitab, buku akademik, repository karya ilmiah, dan peminjaman digital dalam satu sistem premium.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#koleksi"
                       class="flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-600 to-lime-400 px-6 py-4 text-sm font-black text-white shadow-xl shadow-emerald-500/25">
                        <i data-lucide="search" class="h-5 w-5"></i>
                        Jelajahi Koleksi
                    </a>

                    <a href="#repository"
                       class="flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-black text-emerald-700 shadow-xl shadow-emerald-900/5">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                        Lihat Repository
                    </a>
                </div>
            </div>

            <div class="gsap-scale relative">
                <div class="absolute -inset-6 rounded-[3rem] bg-gradient-to-br from-emerald-400 to-lime-300 opacity-30 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-emerald-950 via-emerald-700 to-lime-500 p-6 text-white shadow-2xl shadow-emerald-900/30">
                    <div class="flex items-center justify-between">
                        <div class="h-20 w-20 overflow-hidden rounded-[1.5rem] border-4 border-yellow-400 bg-white p-2">
                            <img src="{{ asset('logo-ahwaluna.png') }}" class="h-full w-full object-contain">
                        </div>

                        <div class="rounded-full border border-yellow-300/60 bg-white/10 px-4 py-2 text-xs font-black text-yellow-300">
                            DIGITAL LIBRARY
                        </div>
                    </div>

                    <div class="mt-10 rounded-[2rem] bg-white/15 p-5 backdrop-blur">
                        <i data-lucide="book-open-check" class="h-12 w-12 text-yellow-300"></i>
                        <h3 class="mt-5 text-3xl font-black">Ilmu, Adab, Amal</h3>
                        <p class="mt-3 text-sm font-semibold leading-relaxed text-lime-50">
                            Menghubungkan tradisi literasi pesantren dengan sistem perpustakaan digital modern.
                        </p>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div class="rounded-3xl bg-white/15 p-4 backdrop-blur">
                            <p class="text-3xl font-black">{{ $totalBooks }}</p>
                            <p class="text-xs font-bold text-lime-100">Buku</p>
                        </div>
                        <div class="rounded-3xl bg-white/15 p-4 backdrop-blur">
                            <p class="text-3xl font-black">{{ $totalRepositories }}</p>
                            <p class="text-xs font-bold text-lime-100">Repository</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="mx-auto max-w-7xl px-5 py-10">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="gsap-scale rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <i data-lucide="book-open" class="h-8 w-8 text-emerald-600"></i>
                <p class="mt-4 text-3xl font-black">{{ $totalBooks }}</p>
                <p class="text-xs font-black text-slate-500">Koleksi Buku</p>
            </div>

            <div class="gsap-scale rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <i data-lucide="users" class="h-8 w-8 text-emerald-600"></i>
                <p class="mt-4 text-3xl font-black">{{ $totalMembers }}</p>
                <p class="text-xs font-black text-slate-500">Anggota</p>
            </div>

            <div class="gsap-scale rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <i data-lucide="graduation-cap" class="h-8 w-8 text-emerald-600"></i>
                <p class="mt-4 text-3xl font-black">{{ $totalRepositories }}</p>
                <p class="text-xs font-black text-slate-500">Repository</p>
            </div>

            <div class="gsap-scale rounded-[2rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-5 text-white shadow-xl shadow-emerald-500/20">
                <i data-lucide="repeat" class="h-8 w-8"></i>
                <p class="mt-4 text-3xl font-black">{{ $totalLoans }}</p>
                <p class="text-xs font-black text-lime-100">Peminjaman</p>
            </div>
        </div>
    </section>

    {{-- KOLEKSI --}}
    <section id="koleksi" class="mx-auto max-w-7xl px-5 py-14">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-black tracking-[0.25em] text-emerald-600">KOLEKSI</p>
                <h3 class="mt-2 text-3xl font-black text-slate-950">Buku Terbaru</h3>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($latestBooks as $book)
                <div class="gsap-fade-up rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5">
                    <div class="flex gap-4">
                        @if($book->cover)
                            <img src="{{ asset($book->cover) }}" class="h-28 w-24 rounded-2xl object-cover shadow-lg">
                        @else
                            <div class="flex h-28 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-lime-400 text-white">
                                <i data-lucide="book-open" class="h-10 w-10"></i>
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <h4 class="line-clamp-2 text-base font-black text-slate-900">{{ $book->title }}</h4>
                            <p class="mt-2 text-xs font-bold text-slate-500">{{ $book->author ?? '-' }}</p>
                            <p class="mt-3 inline-flex rounded-full bg-lime-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                {{ $book->category->name ?? 'Tanpa Kategori' }}
                            </p>
                            <p class="mt-2 text-xs font-bold text-slate-500">
                                Rak {{ $book->shelf->code ?? '-' }} • Stok {{ $book->available_stock }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm font-bold text-slate-500">Belum ada buku.</p>
            @endforelse
        </div>
    </section>

    {{-- REPOSITORY --}}
    <section id="repository" class="mx-auto max-w-7xl px-5 py-14">
        <div class="rounded-[2.5rem] bg-gradient-to-br from-emerald-950 via-emerald-700 to-lime-500 p-6 text-white shadow-2xl shadow-emerald-900/25 md:p-10">
            <div class="mb-8">
                <p class="text-sm font-black tracking-[0.25em] text-yellow-300">REPOSITORY</p>
                <h3 class="mt-2 text-3xl font-black">Karya Ilmiah Terbaru</h3>
                <p class="mt-3 max-w-2xl text-sm font-semibold text-lime-50">
                    Arsip digital skripsi, jurnal, artikel, makalah, dan kitab digital.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @forelse($latestRepositories as $repo)
                    <div class="gsap-scale rounded-[2rem] bg-white/15 p-5 backdrop-blur">
                        <i data-lucide="file-text" class="h-9 w-9 text-yellow-300"></i>
                        <h4 class="mt-4 line-clamp-2 text-base font-black">{{ $repo->title }}</h4>
                        <p class="mt-2 text-xs font-bold text-lime-100">
                            {{ $repo->author }} • {{ $repo->year ?? '-' }}
                        </p>
                        <span class="mt-4 inline-flex rounded-full bg-white/20 px-3 py-1 text-[11px] font-black">
                            {{ strtoupper($repo->type) }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm font-bold text-lime-100">Belum ada repository.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FITUR --}}
    <section id="fitur" class="mx-auto max-w-7xl px-5 py-14">
        <div class="mb-8 text-center">
            <p class="text-sm font-black tracking-[0.25em] text-emerald-600">FITUR</p>
            <h3 class="mt-2 text-3xl font-black text-slate-950">Fitur Unggulan</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            @foreach([
                ['icon' => 'qr-code', 'title' => 'QR Anggota', 'desc' => 'Kartu anggota digital premium.'],
                ['icon' => 'scan-line', 'title' => 'Scan Peminjaman', 'desc' => 'Transaksi lebih cepat dan modern.'],
                ['icon' => 'book-open-check', 'title' => 'Katalog Buku', 'desc' => 'Data koleksi tersusun rapi.'],
                ['icon' => 'file-text', 'title' => 'Repository', 'desc' => 'Arsip karya ilmiah digital.'],
            ] as $item)
                <div class="gsap-scale rounded-[2rem] bg-white p-5 text-center shadow-xl shadow-emerald-900/5">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-lime-100 text-emerald-700">
                        <i data-lucide="{{ $item['icon'] }}" class="h-7 w-7"></i>
                    </div>
                    <h4 class="mt-4 font-black text-slate-900">{{ $item['title'] }}</h4>
                    <p class="mt-2 text-xs font-bold leading-relaxed text-slate-500">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="mt-10 bg-emerald-950 px-5 py-10 text-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 text-center md:flex-row md:text-left">
            <div class="flex items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl bg-white p-1">
                    <img src="{{ asset('logo-ahwaluna.png') }}" class="h-full w-full object-contain">
                </div>
                <div>
                    <h4 class="font-black">Ahwaluna Library</h4>
                    <p class="text-xs font-bold text-lime-100">Ma'had Aly Kebon Jambu</p>
                </div>
            </div>

            <p class="text-xs font-bold text-lime-100">
                © {{ date('Y') }} Ahwaluna Library. Ilmu • Adab • Amal
            </p>
        </div>
    </footer>

</body>
</html>
