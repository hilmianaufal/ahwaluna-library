<x-mahasantri-layout>
    <section class="space-y-5">

        <a href="{{ route('mahasantri.catalog') }}"
           class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
            <i data-lucide="arrow-left"></i>
        </a>

        <div class="overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">
            <div class="bg-gradient-to-br from-emerald-600 to-lime-400 p-6 text-white">
                <div class="flex justify-center">
                    @if ($book->cover)
                        <img src="{{ asset($book->cover) }}"
                             class="h-56 w-40 rounded-3xl object-cover shadow-2xl">
                    @else
                        <div class="flex h-56 w-40 items-center justify-center rounded-3xl bg-white/20">
                            <i data-lucide="book-open" class="h-16 w-16"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-5">
                <p class="text-xs font-black text-emerald-600">{{ $book->code }}</p>

                <h2 class="mt-2 text-2xl font-black leading-tight text-slate-900">
                    {{ $book->title }}
                </h2>

                <p class="mt-2 text-sm font-bold text-slate-500">
                    {{ $book->author ?? 'Tanpa Penulis' }}
                </p>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-3xl bg-lime-50 p-4">
                        <p class="text-[10px] font-black text-slate-400">Kategori</p>
                        <p class="mt-1 text-sm font-black text-slate-800">
                            {{ $book->category->name ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-lime-50 p-4">
                        <p class="text-[10px] font-black text-slate-400">Rak</p>
                        <p class="mt-1 text-sm font-black text-slate-800">
                            {{ $book->shelf->code ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-lime-50 p-4">
                        <p class="text-[10px] font-black text-slate-400">Tahun</p>
                        <p class="mt-1 text-sm font-black text-slate-800">
                            {{ $book->year ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-lime-50 p-4">
                        <p class="text-[10px] font-black text-slate-400">Stok</p>
                        <p class="mt-1 text-sm font-black {{ $book->available_stock > 0 ? 'text-emerald-700' : 'text-red-600' }}">
                            {{ $book->available_stock > 0 ? $book->available_stock . ' tersedia' : 'Habis' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 rounded-3xl bg-lime-50 p-4">
                    <p class="text-[10px] font-black text-slate-400">Penerbit</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $book->publisher ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

    </section>
</x-mahasantri-layout>
