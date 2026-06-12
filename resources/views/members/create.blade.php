<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center gap-4">
            <a href="{{ route('members.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Anggota</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Tambahkan data mahasantri perpustakaan
                </p>
            </div>
        </div>

        <form action="{{ route('members.store') }}" me method="POST" enctype="multipart/form-data"
              class="gsap-fade-up space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nama mahasantri">
                @error('name')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Nomor Induk Mahasantri">
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Program Studi</label>
                <input type="text" name="program_study" value="{{ old('program_study') }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Contoh: Fiqih dan Ushul Fiqih">
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Angkatan</label>
                    <input type="text" name="class_year" value="{{ old('class_year') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="2024">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">No HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                           placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Status</label>
                <select name="status"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <option value="active" @selected(old('status') == 'active')>Aktif</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Foto Anggota</label>

                <input type="file" name="photo" accept="image/*"
                    class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">

                <p class="mt-1 text-xs font-bold text-slate-400">
                    Format JPG, PNG, WEBP. Maksimal 2MB.
                </p>
            </div>
            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Akun Login Mahasantri</label>

                <select name="user_id"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <option value="">Belum dihubungkan</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} - {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="save" class="h-5 w-5"></i>
                Simpan Anggota
            </button>
        </form>

    </section>
</x-app-layout>
