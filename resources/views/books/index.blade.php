<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Data Buku</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Kelola koleksi buku Ahwaluna Library
                </p>
            </div>

            <a href="{{ route('books.create') }}"
               class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-4 py-3 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="plus" class="h-5 w-5"></i>
                <span class="hidden sm:inline">Tambah</span>
            </a>
        </div>

        @if (session('success'))
            <div class="gsap-fade-up rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-bold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="gsap-fade-up rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5">
            <div class="mb-4 flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>
                <input
                    type="text"
                    placeholder="Cari buku..."
                    class="w-full border-0 bg-transparent text-sm font-bold text-slate-700 placeholder:text-slate-400 focus:ring-0"
                    onkeyup="searchBook(this.value)"
                >
            </div>

            <div class="space-y-3" id="bookList">
                @forelse ($books as $book)
                    <div class="book-item rounded-[1.7rem] bg-lime-50 p-4"
                         data-title="{{ strtolower($book->title) }}"
                         data-author="{{ strtolower($book->author ?? '') }}"
                         data-code="{{ strtolower($book->code) }}">

                        <div class="flex gap-4">
                            @if ($book->cover)
                                <img src="{{ asset($book->cover) }}"
                                    class="h-16 w-16 shrink-0 rounded-2xl object-cover shadow-lg">
                            @else
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white shadow-lg shadow-emerald-500/20">
                                    <i data-lucide="book-open" class="h-8 w-8"></i>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-black text-slate-900">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="mt-1 truncate text-xs font-bold text-slate-500">
                                            {{ $book->author ?? 'Tanpa Penulis' }}
                                        </p>
                                    </div>

                                    <span class="shrink-0 rounded-full bg-white px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ $book->code }}
                                    </span>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Rak {{ $book->shelf->code ?? '-' }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Stok {{ $book->available_stock }}/{{ $book->stock }}
                                    </span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('books.show', $book) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-white px-3 py-2 text-xs font-black text-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        Detail
                                    </a>

                                    <a href="{{ route('books.edit', $book) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-lime-200 px-3 py-2 text-xs font-black text-emerald-700">
                                        <i data-lucide="edit-3" class="h-4 w-4"></i>
                                        Edit
                                    </a>

                                    <a href="{{ route('books.qr',$book) }}"
                                        class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-blue-100 px-3 py-2 text-xs font-black text-blue-700">
                                            <i data-lucide="qr-code"></i>
                                            QR
                                        </a>

                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex h-full items-center justify-center rounded-2xl bg-red-100 px-3 py-2 text-red-600">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[2rem] bg-lime-50 p-8 text-center">
                        <i data-lucide="book-x" class="mx-auto h-12 w-12 text-slate-400"></i>
                        <p class="mt-3 text-sm font-black text-slate-500">
                            Belum ada data buku.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $books->links() }}
            </div>
        </div>

    </section>

    <script>
        function searchBook(keyword) {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.book-item').forEach(item => {
                let title = item.dataset.title;
                let author = item.dataset.author;
                let code = item.dataset.code;

                if (
                    title.includes(keyword) ||
                    author.includes(keyword) ||
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