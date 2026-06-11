<x-app-layout>
    <section class="space-y-6">

        <div class="flex items-center gap-4">
            <a href="{{ route('shelves.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Edit Rak Buku</h2>
                <p class="text-sm font-bold text-slate-500">Perbarui lokasi rak buku</p>
            </div>
        </div>

        <form action="{{ route('shelves.update', $shelf) }}" method="POST"
              class="space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-black">Kode Rak</label>
                <input type="text" name="code" value="{{ old('code', $shelf->code) }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black">Nama Rak</label>
                <input type="text" name="name" value="{{ old('name', $shelf->name) }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $shelf->location) }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 font-bold">
            </div>

            <button class="w-full rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 py-4 text-sm font-black text-white">
                Update Rak
            </button>
        </form>

    </section>
</x-app-layout>