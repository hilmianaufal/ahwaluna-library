<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Repository</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Karya ilmiah, skripsi, jurnal, dan dokumen akademik
                </p>
            </div>

            <a href="{{ route('repositories.create') }}"
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

        <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">

            <div class="mb-5 flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>
                <input
                    type="text"
                    placeholder="Cari judul, penulis, NIM..."
                    class="w-full border-0 bg-transparent text-sm font-bold focus:ring-0"
                    onkeyup="searchRepository(this.value)">
            </div>

            <div class="space-y-3">
                @forelse ($repositories as $repository)
                    <div class="repository-item rounded-[1.8rem] bg-lime-50 p-4"
                         data-title="{{ strtolower($repository->title) }}"
                         data-author="{{ strtolower($repository->author) }}"
                         data-nim="{{ strtolower($repository->nim ?? '') }}">

                        <div class="flex gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="file-text" class="h-8 w-8"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="line-clamp-2 text-base font-black text-slate-900">
                                            {{ $repository->title }}
                                        </h3>
                                        <p class="mt-1 text-xs font-bold text-slate-500">
                                            {{ $repository->author }} • {{ $repository->year ?? '-' }}
                                        </p>
                                    </div>

                                    <span class="shrink-0 rounded-full bg-white px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ strtoupper($repository->type) }}
                                    </span>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        NIM: {{ $repository->nim ?? '-' }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Dilihat {{ $repository->view_count }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Download {{ $repository->download_count }}
                                    </span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('repositories.show', $repository) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-white px-3 py-2 text-xs font-black text-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        Detail
                                    </a>

                                    <a href="{{ route('repositories.edit', $repository) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-lime-200 px-3 py-2 text-xs font-black text-emerald-700">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('repositories.destroy', $repository) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus repository ini?')">
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
                        <i data-lucide="graduation-cap" class="mx-auto h-12 w-12 text-slate-400"></i>
                        <p class="mt-3 text-sm font-black text-slate-500">
                            Belum ada data repository.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $repositories->links() }}
            </div>
        </div>

    </section>

    <script>
        function searchRepository(keyword) {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.repository-item').forEach(item => {
                let title = item.dataset.title;
                let author = item.dataset.author;
                let nim = item.dataset.nim;

                if (
                    title.includes(keyword) ||
                    author.includes(keyword) ||
                    nim.includes(keyword)
                ) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>