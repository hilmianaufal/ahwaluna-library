<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up">
            <h2 class="text-2xl font-black text-slate-900">Laporan Peminjaman</h2>
            <p class="mt-1 text-sm font-bold text-slate-500">
                Filter dan rekap transaksi peminjaman buku
            </p>
        </div>

        <form method="GET"
              class="gsap-fade-up grid gap-3 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5 md:grid-cols-4">

            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold">

            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold">

            <select name="status"
                    class="rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold">
                <option value="">Semua Status</option>
                <option value="borrowed" @selected(request('status') == 'borrowed')>Dipinjam</option>
                <option value="returned" @selected(request('status') == 'returned')>Dikembalikan</option>
                <option value="late" @selected(request('status') == 'late')>Terlambat</option>
            </select>

            <button class="rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-3 text-sm font-black text-white">
                Filter
            </button>

            <a href="{{ route('reports.loans.pdf', request()->query()) }}"
            class="flex items-center justify-center rounded-2xl bg-red-100 px-5 py-3 text-sm font-black text-red-600">
                Export PDF
            </a>

            <a href="{{ route('reports.loans.excel', request()->query()) }}"
            class="flex items-center justify-center rounded-2xl bg-emerald-100 px-5 py-3 text-sm font-black text-emerald-700">
                Export Excel
            </a>
        </form>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="gsap-scale rounded-[2rem] bg-gradient-to-br from-emerald-500 to-lime-400 p-5 text-white shadow-xl shadow-emerald-500/20">
                <i data-lucide="repeat" class="h-7 w-7"></i>
                <p class="mt-4 text-3xl font-black">{{ $totalLoans }}</p>
                <p class="text-sm font-bold text-lime-100">Total Peminjaman</p>
            </div>

            <div class="gsap-scale rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <i data-lucide="coins" class="h-7 w-7 text-emerald-600"></i>
                <p class="mt-4 text-3xl font-black text-slate-900">
                    Rp {{ number_format($totalFine, 0, ',', '.') }}
                </p>
                <p class="text-sm font-bold text-slate-500">Total Denda</p>
            </div>
        </div>

        <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            <div class="space-y-3">
                @forelse ($loans as $loan)
                    <div class="rounded-[1.7rem] bg-lime-50 p-4">
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="book-open" class="h-7 w-7"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-sm font-black text-slate-900">
                                    {{ $loan->book->title ?? '-' }}
                                </h3>
                                <p class="mt-1 text-xs font-bold text-slate-500">
                                    {{ $loan->member->name ?? '-' }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        {{ $loan->borrowed_at->format('d M Y') }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Denda Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                    </span>

                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ strtoupper($loan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[2rem] bg-lime-50 p-8 text-center">
                        <i data-lucide="file-x" class="mx-auto h-12 w-12 text-slate-400"></i>
                        <p class="mt-3 text-sm font-black text-slate-500">
                            Data laporan tidak ditemukan.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $loans->links() }}
            </div>
        </div>

    </section>
</x-app-layout>