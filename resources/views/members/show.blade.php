<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('members.index') }}"
                   class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                    <i data-lucide="arrow-left" class="h-5 w-5"></i>
                </a>

                <div>
                    <h2 class="text-2xl font-black text-slate-900">Detail Anggota</h2>
                    <p class="mt-1 text-sm font-bold text-slate-500">Profil anggota perpustakaan</p>
                </div>
            </div>

            <a href="{{ route('members.edit', $member) }}"
               class="flex items-center gap-2 rounded-2xl bg-lime-100 px-4 py-3 text-sm font-black text-emerald-700">
                <i data-lucide="edit-3" class="h-5 w-5"></i>
                Edit
            </a>

            <a href="{{ route('members.card',$member) }}"
                class="flex items-center justify-center gap-2 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-black text-emerald-700">
                    <i data-lucide="id-card"></i>
                    Kartu Anggota
                </a>
        </div>

        <div class="gsap-fade-up overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">
            <div class="bg-gradient-to-br from-emerald-500 to-lime-400 p-6 text-white">
                <div class="flex items-center gap-5">
                    @if ($member->photo)
                        <img src="{{ asset($member->photo) }}"
                            class="h-24 w-24 shrink-0 rounded-[2rem] object-cover shadow-xl">
                    @else
                        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[2rem] bg-white/20 backdrop-blur">
                            <i data-lucide="user-round" class="h-12 w-12"></i>
                        </div>
                    @endif

                    <div class="min-w-0">
                        <p class="text-xs font-black text-lime-100">{{ $member->member_code }}</p>
                        <h3 class="mt-1 text-2xl font-black leading-tight">{{ $member->name }}</h3>
                        <p class="mt-2 text-sm font-bold text-emerald-50">{{ $member->nim ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 p-5 md:grid-cols-2">
                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Program Studi</p>
                    <p class="mt-1 text-sm font-black text-slate-800">{{ $member->program_study ?? '-' }}</p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Angkatan</p>
                    <p class="mt-1 text-sm font-black text-slate-800">{{ $member->class_year ?? '-' }}</p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">No HP</p>
                    <p class="mt-1 text-sm font-black text-slate-800">{{ $member->phone ?? '-' }}</p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Status</p>
                    <p class="mt-1 text-sm font-black {{ $member->status == 'active' ? 'text-emerald-700' : 'text-red-600' }}">
                        {{ $member->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                    </p>
                </div>
            </div>
        </div>

    </section>
</x-app-layout>