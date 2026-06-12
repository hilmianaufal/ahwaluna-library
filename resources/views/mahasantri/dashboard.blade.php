<x-mahasantri-layout>
    <section class="space-y-6">

        <div class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-6 text-white shadow-2xl shadow-emerald-500/25">
            <p class="text-sm font-bold text-lime-100">Assalamu'alaikum</p>
            <h2 class="mt-1 text-2xl font-black">
                {{ auth()->user()->name }}
            </h2>
            <p class="mt-2 text-sm font-semibold text-emerald-50">
                Dashboard Mahasantri Ahwaluna Library
            </p>
        </div>

        @if (!$member)
            <div class="rounded-[2rem] bg-red-100 p-5 text-sm font-black text-red-600">
                Akun ini belum terhubung dengan data anggota perpustakaan.
            </div>
        @else
            <div class="rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex items-center gap-4">
                    @if ($member->photo)
                        <img src="{{ asset($member->photo) }}"
                             class="h-20 w-20 rounded-3xl object-cover shadow-lg">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-lime-100 text-emerald-700">
                            <i data-lucide="user-round" class="h-10 w-10"></i>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-black text-emerald-600">{{ $member->member_code }}</p>
                        <h3 class="text-lg font-black text-slate-900">{{ $member->name }}</h3>
                        <p class="text-xs font-bold text-slate-500">{{ $member->nim }}</p>
                        <p class="text-xs font-bold text-slate-500">{{ $member->program_study }}</p>
                    </div>
                </div>

                <a href="{{ route('mahasantri.card') }}"
                   class="mt-5 flex items-center justify-center gap-2 rounded-2xl bg-lime-100 px-4 py-3 text-sm font-black text-emerald-700">
                    <i data-lucide="id-card" class="h-5 w-5"></i>
                    Lihat Kartu Anggota
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                    <i data-lucide="repeat" class="h-7 w-7 text-emerald-600"></i>
                    <p class="mt-4 text-2xl font-black text-slate-900">{{ $activeLoans->count() }}</p>
                    <p class="text-xs font-black text-slate-500">Sedang Dipinjam</p>
                </div>

                <div class="rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                    <i data-lucide="alert-circle" class="h-7 w-7 text-red-500"></i>
                    <p class="mt-4 text-2xl font-black text-slate-900">
                        {{ $activeLoans->where('status', 'late')->count() }}
                    </p>
                    <p class="text-xs font-black text-slate-500">Terlambat</p>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <h3 class="text-lg font-black text-slate-900">Pinjaman Aktif</h3>

                <div class="mt-4 space-y-3">
                    @forelse ($activeLoans as $loan)
                        <div class="rounded-3xl bg-lime-50 p-4">
                            <h4 class="font-black text-slate-900">{{ $loan->book->title ?? '-' }}</h4>
                            <p class="mt-1 text-xs font-bold text-slate-500">
                                Jatuh tempo: {{ $loan->due_at->format('d M Y') }}
                            </p>

                            @if ($loan->status == 'late')
                                <span class="mt-3 inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-black text-red-600">
                                    Terlambat
                                </span>
                            @else
                                <span class="mt-3 inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-black text-blue-600">
                                    Dipinjam
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm font-bold text-slate-500">
                            Tidak ada pinjaman aktif.
                        </p>
                    @endforelse
                </div>
            </div>
        @endif

    </section>
</x-mahasantri-layout>
