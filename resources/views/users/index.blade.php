<x-app-layout>
    <section class="space-y-6">

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-black text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Manajemen Users
                </h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Kelola akun admin, petugas, dan kepala perpustakaan
                </p>
            </div>

            <a href="{{ route('users.create') }}"
               class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-3 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="plus"></i>
                Tambah User
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-3">

            <div class="rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                    <i data-lucide="users"></i>
                </div>

                <p class="mt-4 text-2xl font-black text-slate-900">
                    {{ \App\Models\User::count() }}
                </p>

                <p class="text-xs font-black text-slate-500">
                    Total Users
                </p>
            </div>

            <div class="rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <i data-lucide="shield"></i>
                </div>

                <p class="mt-4 text-2xl font-black text-slate-900">
                    {{ \App\Models\User::where('role','admin')->count() }}
                </p>

                <p class="text-xs font-black text-slate-500">
                    Admin
                </p>
            </div>

            <div class="rounded-[1.7rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-700">
                    <i data-lucide="user-check"></i>
                </div>

                <p class="mt-4 text-2xl font-black text-slate-900">
                    {{ \App\Models\User::where('role','petugas')->count() }}
                </p>

                <p class="text-xs font-black text-slate-500">
                    Petugas
                </p>
            </div>

        </div>

        <div class="overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">

            <div class="border-b border-slate-100 p-5">
                <h3 class="font-black text-slate-900">
                    Daftar Pengguna
                </h3>
            </div>

            <div class="divide-y divide-slate-100">

                @forelse($users as $user)

                    <div class="flex items-center justify-between gap-4 p-5">

                        <div class="flex items-center gap-4">

                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                <i data-lucide="user-round"></i>
                            </div>

                            <div>
                                <h4 class="font-black text-slate-900">
                                    {{ $user->name }}
                                </h4>

                                <p class="text-sm font-bold text-slate-500">
                                    {{ $user->email }}
                                </p>

                                <span class="mt-1 inline-flex rounded-xl bg-lime-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </div>

                        </div>

                        <div class="flex items-center gap-2">

                            <a href="{{ route('users.edit', $user) }}"
                               class="rounded-2xl bg-blue-100 px-4 py-2 text-xs font-black text-blue-700">
                                Edit
                            </a>

                            @if(auth()->id() != $user->id)
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="rounded-2xl bg-red-100 px-4 py-2 text-xs font-black text-red-700">
                                    Hapus
                                </button>
                            </form>
                            @endif

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <i data-lucide="users"
                           class="mx-auto h-12 w-12 text-slate-300"></i>

                        <p class="mt-3 text-sm font-bold text-slate-500">
                            Belum ada user
                        </p>

                    </div>

                @endforelse

            </div>

            <div class="border-t border-slate-100 p-5">
                {{ $users->links() }}
            </div>

        </div>

    </section>
</x-app-layout>
