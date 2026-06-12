<x-mahasantri-layout>
    <section class="space-y-5">

        <div class="rounded-[2rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-6 text-white shadow-xl shadow-emerald-500/20">
            <h2 class="text-2xl font-black">Repository</h2>
            <p class="mt-2 text-sm font-bold text-lime-100">
                Karya ilmiah, skripsi, jurnal, dan kitab digital
            </p>
        </div>

        <div class="rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5">
            <div class="flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>
                <input type="text"
                       placeholder="Cari judul / penulis..."
                       onkeyup="searchRepository(this.value)"
                       class="w-full border-0 bg-transparent text-sm font-bold focus:ring-0">
            </div>
        </div>

        <div class="space-y-3">
            @forelse ($repositories as $repository)
                <div class="repository-item rounded-[2rem] bg-white p-4 shadow-xl shadow-emerald-900/5"
                     data-title="{{ strtolower($repository->title) }}"
                     data-author="{{ strtolower($repository->author) }}"
                     data-type="{{ strtolower($repository->type) }}">

                    <div class="flex gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-600 to-lime-400 text-white">
                            <i data-lucide="file-text" class="h-8 w-8"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="line-clamp-2 text-base font-black text-slate-900">
                                {{ $repository->title }}
                            </h3>

                            <p class="mt-1 text-xs font-bold text-slate-500">
                                {{ $repository->author }} • {{ $repository->year ?? '-' }}
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="rounded-full bg-lime-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                    {{ strtoupper($repository->type) }}
                                </span>

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-black text-slate-600">
                                    Dilihat {{ $repository->view_count }}
                                </span>

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-[11px] font-black text-slate-600">
                                    Download {{ $repository->download_count }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($repository->pdf_file)
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <a href="{{ asset($repository->pdf_file) }}" target="_blank"
                               class="flex items-center justify-center gap-2 rounded-2xl bg-lime-100 px-4 py-3 text-xs font-black text-emerald-700">
                                <i data-lucide="book-open" class="h-4 w-4"></i>
                                Baca
                            </a>

                            <a href="{{ route('repositories.download', $repository) }}"
                               class="flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-4 py-3 text-xs font-black text-white">
                                <i data-lucide="download" class="h-4 w-4"></i>
                                Download
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="rounded-[2rem] bg-white p-8 text-center shadow-xl">
                    <i data-lucide="file-x" class="mx-auto h-12 w-12 text-slate-400"></i>
                    <p class="mt-3 text-sm font-black text-slate-500">
                        Belum ada repository.
                    </p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $repositories->links() }}
        </div>

    </section>

    <script>
        function searchRepository(keyword) {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.repository-item').forEach(item => {
                let title = item.dataset.title;
                let author = item.dataset.author;
                let type = item.dataset.type;

                if (
                    title.includes(keyword) ||
                    author.includes(keyword) ||
                    type.includes(keyword)
                ) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</x-mahasantri-layout>
