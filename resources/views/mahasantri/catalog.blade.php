<x-mahasantri-layout>
    <section class="space-y-5">

        <div class="rounded-[2rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-6 text-white shadow-xl shadow-emerald-500/20">
            <h2 class="text-2xl font-black">Katalog Buku</h2>
            <p class="mt-2 text-sm font-bold text-lime-100">
                Cari koleksi buku Ahwaluna Library
            </p>
        </div>

        <div class="rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5">
            <div class="flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>
                <input type="text"
                       placeholder="Cari judul / penulis..."
                       onkeyup="searchBook(this.value)"
                       class="w-full border-0 bg-transparent text-sm font-bold focus:ring-0">
            </div>
        </div>

        <div class="space-y-3" id="bookList">
            @forelse ($books as $book)
                <div class="book-item rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5"
                     data-title="{{ strtolower($book->title) }}"
                     data-author="{{ strtolower($book->author ?? '') }}"
                     data-category="{{ strtolower($book->category->name ?? '') }}">

                    <div class="flex gap-4">
                        @if ($book->cover)
                            <img src="{{ asset($book->cover) }}"
                                 class="h-28 w-24 rounded-2xl object-cover shadow-lg">
                        @else
                            <div class="flex h-28 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-lime-400 text-white">
                                <i data-lucide="book-open" class="h-10 w-10"></i>
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <h3 class="line-clamp-2 text-base font-black text-slate-900">
                                {{ $book->title }}
                            </h3>

                            <p class="mt-1 text-xs font-bold text-slate-500">
                                {{ $book->author ?? 'Tanpa Penulis' }}
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="rounded-full bg-lime-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                    {{ $book->category->name ?? 'Kategori' }}
                                </span>

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-black text-slate-600">
                                    Rak {{ $book->shelf->code ?? '-' }}
                                </span>

                                @if ($book->available_stock > 0)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                        Stok {{ $book->available_stock }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-[11px] font-black text-red-600">
                                        Habis
                                    </span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('mahasantri.books.show', $book) }}"
                                class="flex items-center justify-center gap-2 rounded-2xl bg-lime-100 px-4 py-3 text-sm font-black text-emerald-700">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="rounded-[2rem] bg-white p-8 text-center shadow-xl">
                    <i data-lucide="book-x" class="mx-auto h-12 w-12 text-slate-400"></i>
                    <p class="mt-3 text-sm font-black text-slate-500">
                        Belum ada buku.
                    </p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $books->links() }}
        </div>

    </section>

    <script>
        function searchBook(keyword) {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.book-item').forEach(item => {
                let title = item.dataset.title;
                let author = item.dataset.author;
                let category = item.dataset.category;

                if (
                    title.includes(keyword) ||
                    author.includes(keyword) ||
                    category.includes(keyword)
                ) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</x-mahasantri-layout>
