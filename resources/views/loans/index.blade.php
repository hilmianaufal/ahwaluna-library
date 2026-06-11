<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Peminjaman Buku</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Kelola transaksi peminjaman buku
                </p>
            </div>

            <a href="{{ route('loans.create') }}"
               class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-4 py-3 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="plus" class="h-5 w-5"></i>
                Tambah
            </a>
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

        <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">

            <div class="mb-5 flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>
                <input
                    type="text"
                    placeholder="Cari nama anggota / buku..."
                    class="w-full border-0 bg-transparent text-sm font-bold focus:ring-0"
                    onkeyup="searchLoan(this.value)">
            </div>

            <div class="space-y-3">
                @forelse ($loans as $loan)
                    <div class="loan-item rounded-[1.8rem] bg-lime-50 p-4"
                         data-member="{{ strtolower($loan->member->name ?? '') }}"
                         data-book="{{ strtolower($loan->book->title ?? '') }}"
                         data-code="{{ strtolower($loan->loan_code) }}">

                        <div class="flex gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="repeat" class="h-8 w-8"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-black text-slate-900">
                                            {{ $loan->member->name ?? '-' }}
                                        </h3>
                                        <p class="mt-1 truncate text-xs font-bold text-slate-500">
                                            {{ $loan->book->title ?? '-' }}
                                        </p>
                                    </div>

                                    @if ($loan->status == 'borrowed')
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-[11px] font-black text-blue-700">
                                            Dipinjam
                                        </span>
                                    @elseif ($loan->status == 'returned')
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                            Kembali
                                        </span>
                                    @elseif ($loan->status == 'late')
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-[11px] font-black text-red-600">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-black text-slate-600">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    <div class="rounded-2xl bg-white px-3 py-2">
                                        <p class="text-[10px] font-black text-slate-400">Pinjam</p>
                                        <p class="text-xs font-black text-slate-700">
                                            {{ $loan->borrowed_at->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-white px-3 py-2">
                                        <p class="text-[10px] font-black text-slate-400">Jatuh Tempo</p>
                                        <p class="text-xs font-black text-slate-700">
                                            {{ $loan->due_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('loans.show', $loan) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-white px-3 py-2 text-xs font-black text-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        Detail
                                    </a>

                                    @if ($loan->status == 'borrowed' || $loan->status == 'late')
                                    <form action="{{ route('loans.return', $loan) }}" method="POST" class="flex-1"
                                        onsubmit="return confirm('Yakin buku ini sudah dikembalikan?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-100 px-3 py-2 text-xs font-black text-emerald-700">
                                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                                            Kembalikan
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST"
                                          onsubmit="return confirm('Hapus data peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-2xl bg-red-100 px-3 py-2 text-red-600">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[2rem] bg-lime-50 p-8 text-center">
                        <i data-lucide="repeat" class="mx-auto h-12 w-12 text-slate-400"></i>
                        <p class="mt-3 text-sm font-black text-slate-500">
                            Belum ada data peminjaman.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $loans->links() }}
            </div>
        </div>

    </section>

    <script>
        function searchLoan(keyword) {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.loan-item').forEach(item => {
                let member = item.dataset.member;
                let book = item.dataset.book;
                let code = item.dataset.code;

                if (
                    member.includes(keyword) ||
                    book.includes(keyword) ||
                    code.includes(keyword)
                ) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>