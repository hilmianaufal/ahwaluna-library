<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('loans.index') }}"
                   class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                    <i data-lucide="arrow-left" class="h-5 w-5"></i>
                </a>

                <div>
                    <h2 class="text-2xl font-black text-slate-900">Detail Peminjaman</h2>
                    <p class="mt-1 text-sm font-bold text-slate-500">
                        Informasi transaksi peminjaman buku
                    </p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-black text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl bg-red-100 px-4 py-3 text-sm font-black text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <div class="gsap-fade-up overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">
            <div class="bg-gradient-to-br from-emerald-500 to-lime-400 p-6 text-white">
                <div class="flex gap-5">
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[2rem] bg-white/20 backdrop-blur">
                        <i data-lucide="repeat" class="h-12 w-12"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-black text-lime-100">{{ $loan->loan_code }}</p>

                        <h3 class="mt-1 text-2xl font-black leading-tight">
                            {{ $loan->member->name ?? '-' }}
                        </h3>

                        <p class="mt-2 text-sm font-bold text-emerald-50">
                            {{ $loan->book->title ?? '-' }}
                        </p>

                        <div class="mt-3">
                            @if ($loan->status == 'borrowed')
                                <span class="rounded-full bg-white/25 px-3 py-1 text-xs font-black">
                                    Sedang Dipinjam
                                </span>
                            @elseif ($loan->status == 'returned')
                                <span class="rounded-full bg-white/25 px-3 py-1 text-xs font-black">
                                    Sudah Dikembalikan
                                </span>
                            @elseif ($loan->status == 'late')
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-black text-red-600">
                                    Terlambat
                                </span>
                            @else
                                <span class="rounded-full bg-white/25 px-3 py-1 text-xs font-black">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 p-5 md:grid-cols-2">
                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Anggota</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->member->name ?? '-' }}
                    </p>
                    <p class="mt-1 text-xs font-bold text-slate-500">
                        {{ $loan->member->member_code ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Buku</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->book->title ?? '-' }}
                    </p>
                    <p class="mt-1 text-xs font-bold text-slate-500">
                        {{ $loan->book->code ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Tanggal Pinjam</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->borrowed_at->format('d M Y') }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Jatuh Tempo</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->due_at->format('d M Y') }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Tanggal Kembali</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->returned_at ? $loan->returned_at->format('d M Y') : '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Denda</p>
                    <p class="mt-1 text-sm font-black text-red-600">
                        Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4 md:col-span-2">
                    <p class="text-xs font-black text-slate-400">Dicatat Oleh</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $loan->user->name ?? '-' }}
                    </p>
                </div>
            </div>

            @if ($loan->status == 'borrowed' || $loan->status == 'late')
                <div class="p-5 pt-0">
                    <form action="{{ route('loans.return', $loan) }}" method="POST"
                          onsubmit="return confirm('Yakin buku ini sudah dikembalikan?')">
                        @csrf
                        @method('PATCH')

                        <button class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                            <i data-lucide="rotate-ccw" class="h-5 w-5"></i>
                            Kembalikan Buku
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </section>
</x-app-layout>