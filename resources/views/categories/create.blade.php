<x-app-layout>
    <section class="space-y-6">

        <div class="flex items-center gap-4">
            <a href="{{ route('categories.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white shadow-lg">
                <i data-lucide="arrow-left"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Tambah Kategori
                </h2>
                <p class="text-sm font-bold text-slate-500">
                    Tambah kategori baru
                </p>
            </div>
        </div>

        <form action="{{ route('categories.store') }}"
              method="POST"
              class="space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">

            @csrf

            <div>
                <label class="mb-2 block text-sm font-black">
                    Nama Kategori
                </label>

                <input type="text"
                       name="name"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black">
                    Icon Lucide
                </label>

                <input type="text"
                       name="icon"
                       value="book-open"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold"></textarea>
            </div>

            <button
                class="w-full rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 py-4 text-sm font-black text-white">
                Simpan Kategori
            </button>

        </form>

    </section>
</x-app-layout>