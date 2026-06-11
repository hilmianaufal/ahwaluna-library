<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-600 via-emerald-500 to-lime-400 p-6 text-white shadow-2xl shadow-emerald-500/25">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-lime-100">Assalamu'alaikum</p>
                    <h2 class="mt-1 text-2xl font-black leading-tight md:text-4xl">
                        Dashboard Ahwaluna Library
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm font-medium text-emerald-50">
                        Monitoring koleksi buku, anggota, peminjaman, repository, dan denda perpustakaan Ma'had Aly Kebon Jambu.
                    </p>
                </div>

                <div class="hidden h-24 w-24 items-center justify-center rounded-3xl bg-white/20 backdrop-blur md:flex">
                    <i data-lucide="library-big" class="h-12 w-12"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-6">
            <div class="gsap-scale rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-lime-100 text-emerald-700">
                    <i data-lucide="book-open" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-2xl font-black text-slate-900">{{ $totalBooks }}</p>
                <p class="text-xs font-black text-slate-500">Total Buku</p>
            </div>

            <div class="gsap-scale rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                    <i data-lucide="users" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-2xl font-black text-slate-900">{{ $totalMembers }}</p>
                <p class="text-xs font-black text-slate-500">Total Anggota</p>
            </div>

            <div class="gsap-scale rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <i data-lucide="repeat" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-2xl font-black text-slate-900">{{ $totalBorrowed }}</p>
                <p class="text-xs font-black text-slate-500">Buku Dipinjam</p>
            </div>

            <div class="gsap-scale rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-700">
                    <i data-lucide="package-check" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-2xl font-black text-slate-900">{{ $totalAvailableBooks }}</p>
                <p class="text-xs font-black text-slate-500">Buku Tersedia</p>
            </div>

            <div class="gsap-scale rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 text-purple-700">
                    <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-2xl font-black text-slate-900">{{ $totalRepositories }}</p>
                <p class="text-xs font-black text-slate-500">Repository</p>
            </div>

            <div class="gsap-scale rounded-[1.7rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-5 text-white shadow-xl shadow-emerald-500/20">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                    <i data-lucide="coins" class="h-6 w-6"></i>
                </div>
                <p class="mt-4 text-xl font-black">
                    Rp {{ number_format($monthlyFine, 0, ',', '.') }}
                </p>
                <p class="text-xs font-black text-lime-100">Denda Bulan Ini</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5 lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Grafik Peminjaman</h3>
                        <p class="text-xs font-bold text-slate-500">
                            Statistik peminjaman buku tahun {{ now()->year }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-lime-100 px-4 py-2 text-xs font-black text-emerald-700">
                        {{ now()->year }}
                    </div>
                </div>

                <div class="h-72">
                    <canvas id="loanChart"></canvas>
                </div>
            </div>

            <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="mb-5">
                    <h3 class="text-lg font-black text-slate-900">Menu Cepat</h3>
                    <p class="text-xs font-bold text-slate-500">Akses fitur utama</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('books.create') }}" class="flex items-center gap-3 rounded-2xl bg-lime-50 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-lime-100 text-emerald-700">
                            <i data-lucide="plus" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900">Tambah Buku</p>
                            <p class="text-xs font-bold text-slate-500">Input koleksi baru</p>
                        </div>
                    </a>

                    <a href="{{ route('loans.create') }}" class="flex items-center gap-3 rounded-2xl bg-lime-50 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                            <i data-lucide="scan-line" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900">Scan Peminjaman</p>
                            <p class="text-xs font-bold text-slate-500">QR anggota</p>
                        </div>
                    </a>

                    <a href="{{ route('repositories.create') }}" class="flex items-center gap-3 rounded-2xl bg-lime-50 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-purple-100 text-purple-700">
                            <i data-lucide="file-plus" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900">Upload Repository</p>
                            <p class="text-xs font-bold text-slate-500">Skripsi, jurnal, kitab</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Buku Terbaru</h3>
                    <p class="text-xs font-bold text-slate-500">Koleksi terbaru perpustakaan</p>
                </div>

                <a href="{{ route('books.index') }}" class="rounded-2xl bg-lime-100 px-4 py-2 text-xs font-black text-emerald-700">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($latestBooks as $book)
                    <div class="flex items-center gap-4 rounded-3xl bg-lime-50 p-3">
                        @if ($book->cover)
                            <img src="{{ asset($book->cover) }}" class="h-14 w-14 rounded-2xl object-cover shadow-lg">
                        @else
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="book-open" class="h-7 w-7"></i>
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <h4 class="truncate text-sm font-black text-slate-900">
                                {{ $book->title }}
                            </h4>
                            <p class="truncate text-xs font-semibold text-slate-500">
                                {{ $book->author ?? '-' }}
                            </p>
                            <p class="mt-1 text-[11px] font-bold text-emerald-600">
                                {{ $book->category->name ?? 'Tanpa Kategori' }}
                                • Rak {{ $book->shelf->code ?? '-' }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-black text-slate-900">
                                {{ $book->available_stock }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400">
                                Stok
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl bg-lime-50 p-6 text-center">
                        <i data-lucide="book-x" class="mx-auto h-10 w-10 text-slate-400"></i>
                        <p class="mt-3 text-sm font-bold text-slate-500">
                            Belum ada buku.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('loanChart');

            if (ctx && window.Chart) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                        ],
                        datasets: [{
                            label: 'Peminjaman',
                            data: @json($chartData),
                            tension: 0.45,
                            fill: true,
                            borderWidth: 3,
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
