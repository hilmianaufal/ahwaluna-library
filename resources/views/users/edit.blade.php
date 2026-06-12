<x-app-layout>
    <section class="space-y-6">

        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Edit User</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Perbarui data pengguna sistem
                </p>
            </div>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST"
              class="space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">
                    Nama User
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">

                @error('name')
                    <p class="mt-1 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">

                @error('email')
                    <p class="mt-1 text-xs font-bold text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">
                    Password Baru
                </label>

                <input type="password"
                       name="password"
                       class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                       placeholder="Kosongkan jika tidak diubah">

                <p class="mt-1 text-xs font-bold text-slate-400">
                    Biarkan kosong jika password tidak ingin diganti
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">
                    Role
                </label>

                <select name="role"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">

                    <option value="admin"
                        @selected(old('role', $user->role) == 'admin')>
                        Admin
                    </option>

                    <option value="mahasantri" @selected(old('role', $user->role ?? '') == 'mahasantri')>
                        Mahasantri
                    </option>

                </select>
            </div>

            <div class="rounded-3xl bg-lime-50 p-4">
                <p class="text-xs font-black text-slate-500">
                    Role Saat Ini
                </p>

                <p class="mt-1 text-sm font-black text-emerald-700">
                    {{ strtoupper($user->role) }}
                </p>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="save"></i>
                Update User
            </button>

        </form>

    </section>
</x-app-layout>
