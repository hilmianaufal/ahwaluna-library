<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center gap-4">
            <a href="{{ route('repositories.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Repository</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Upload karya ilmiah atau dokumen akademik
                </p>
            </div>
        </div>

        <form action="{{ route('repositories.store') }}" method="POST" enctype="multipart/form-data"
              class="gsap-fade-up space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Judul karya ilmiah">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Penulis</label>
                <input type="text" name="author" value="{{ old('author') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nama penulis">
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="Nomor Induk Mahasantri">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ old('year') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="2026">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Pembimbing</label>
                <input type="text" name="supervisor" value="{{ old('supervisor') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nama dosen pembimbing">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Jenis Dokumen</label>
                <select name="type"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <option value="skripsi">Skripsi</option>
                    <option value="jurnal">Jurnal</option>
                    <option value="makalah">Makalah</option>
                    <option value="artikel">Artikel</option>
                    <option value="kitab">Kitab Digital</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Abstrak</label>
                <textarea name="abstract" rows="5"
                          class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                          placeholder="Tulis abstrak atau ringkasan dokumen">{{ old('abstract') }}</textarea>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">File PDF</label>
                <input type="file" name="pdf_file" accept="application/pdf"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                <p class="mt-1 text-xs font-bold text-slate-400">
                    Format PDF maksimal 10MB.
                </p>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="save" class="h-5 w-5"></i>
                Simpan Repository
            </button>
        </form>

    </section>
</x-app-layout>