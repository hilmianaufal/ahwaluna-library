<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Kategori Buku
                </h2>

                <p class="mt-1 text-sm font-bold text-slate-500">
                    Kelola kategori koleksi perpustakaan
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
               class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-4 py-3 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="plus"></i>
                Tambah
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-black text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="gsap-fade-up rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">

            <div class="space-y-3">

                @forelse($categories as $category)

                    <div class="rounded-[1.8rem] bg-lime-50 p-4">

                        <div class="flex gap-4">

                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="{{ $category->icon }}"></i>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h3 class="text-base font-black text-slate-900">
                                            {{ $category->name }}
                                        </h3>

                                        <p class="mt-1 text-xs font-bold text-slate-500">
                                            {{ $category->slug }}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ $category->books_count }} Buku
                                    </span>

                                </div>

                                <p class="mt-3 text-xs font-semibold leading-relaxed text-slate-500">
                                    {{ $category->description ?: 'Tidak ada deskripsi.' }}
                                </p>

                                <div class="mt-4 flex gap-2">

                                    <a href="{{ route('categories.edit',$category) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-lime-200 px-3 py-2 text-xs font-black text-emerald-700">
                                        <i data-lucide="pencil"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy',$category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus kategori ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="rounded-2xl bg-red-100 px-3 py-2 text-red-600">
                                            <i data-lucide="trash-2"></i>
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-[2rem] bg-lime-50 p-8 text-center">
                        <i data-lucide="tags" class="mx-auto h-12 w-12 text-slate-400"></i>

                        <p class="mt-3 text-sm font-black text-slate-500">
                            Belum ada kategori.
                        </p>
                    </div>

                @endforelse

            </div>

            <div class="mt-5">
                {{ $categories->links() }}
            </div>

        </div>

    </section>
</x-app-layout>