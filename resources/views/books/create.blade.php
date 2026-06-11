<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center gap-4">
            <a href="{{ route('books.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg shadow-emerald-900/5">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Buku</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Tambahkan koleksi baru perpustakaan
                </p>
            </div>
        </div>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
              class="gsap-fade-up space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Judul Buku</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Contoh: Fathul Muin">
                @error('title')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Penulis</label>
                <input type="text" name="author" value="{{ old('author') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nama penulis">
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Kategori</label>
                    <select name="category_id"
                            class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Rak Buku</label>
                    <select name="shelf_id"
                            class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                        <option value="">Pilih rak</option>
                        @foreach ($shelves as $shelf)
                            <option value="{{ $shelf->id }}" @selected(old('shelf_id') == $shelf->id)>
                                {{ $shelf->code }} - {{ $shelf->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nama penerbit">
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ old('year') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="2024">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="ISBN">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>

            <div class="rounded-[1.5rem] bg-lime-50 p-4">
                <div class="flex gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <i data-lucide="info" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-800">Kode buku otomatis</h4>
                        <p class="mt-1 text-xs font-bold leading-relaxed text-slate-500">
                            Sistem akan membuat kode buku otomatis seperti BK-ABC123.
                        </p>
                    </div>
                </div>
            </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Cover Buku</label>
                    <input type="file" name="cover" accept="image/*"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <p class="mt-1 text-xs font-bold text-slate-400">
                        Format: JPG, PNG, WEBP. Maksimal 2MB.
                    </p>
                </div>
            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="save" class="h-5 w-5"></i>
                Simpan Buku
            </button>
        </form>

    </section>
</x-app-layout>