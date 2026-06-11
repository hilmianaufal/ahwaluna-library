<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('books.index') }}"
                   class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                    <i data-lucide="arrow-left" class="h-5 w-5"></i>
                </a>

                <div>
                    <h2 class="text-2xl font-black text-slate-900">Detail Buku</h2>
                    <p class="mt-1 text-sm font-bold text-slate-500">
                        Informasi lengkap koleksi buku
                    </p>
                </div>
            </div>

            <a href="{{ route('books.edit', $book) }}"
               class="flex items-center gap-2 rounded-2xl bg-lime-100 px-4 py-3 text-sm font-black text-emerald-700">
                <i data-lucide="edit-3" class="h-5 w-5"></i>
                Edit
            </a>
        </div>

        <div class="gsap-fade-up overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">
            <div class="bg-gradient-to-br from-emerald-500 to-lime-400 p-6 text-white">
                <div class="flex gap-5">
                    @if ($book->cover)
                        <img src="{{ asset($book->cover) }}"
                            class="h-28 w-24 shrink-0 rounded-3xl object-cover shadow-xl">
                    @else
                        <div class="flex h-24 w-20 shrink-0 items-center justify-center rounded-3xl bg-white/20 backdrop-blur">
                            <i data-lucide="book-open" class="h-10 w-10"></i>
                        </div>
                    @endif

                    <div class="min-w-0">
                        <p class="text-xs font-black text-lime-100">{{ $book->code }}</p>
                        <h3 class="mt-1 text-2xl font-black leading-tight">
                            {{ $book->title }}
                        </h3>
                        <p class="mt-2 text-sm font-bold text-emerald-50">
                            {{ $book->author ?? 'Tanpa Penulis' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 p-5 md:grid-cols-2">
                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Kategori</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->category->name ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Rak</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->shelf->code ?? '-' }} - {{ $book->shelf->name ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Penerbit</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->publisher ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Tahun</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->year ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">ISBN</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->isbn ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Stok Tersedia</p>
                    <p class="mt-1 text-sm font-black text-emerald-700">
                        {{ $book->available_stock }} / {{ $book->stock }}
                    </p>
                </div>
            </div>
        </div>

    </section>
</x-app-layout>