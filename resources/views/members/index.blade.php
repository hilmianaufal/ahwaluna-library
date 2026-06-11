<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Anggota Perpustakaan
                </h2>

                <p class="mt-1 text-sm font-bold text-slate-500">
                    Data Mahasantri Ma'had Aly Kebon Jambu
                </p>
            </div>

            <a href="{{ route('members.create') }}"
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

            <div class="mb-5">
                <div class="flex items-center gap-3 rounded-2xl bg-lime-50 px-4 py-3">
                    <i data-lucide="search" class="h-5 w-5 text-emerald-600"></i>

                    <input
                        type="text"
                        placeholder="Cari anggota..."
                        class="w-full border-0 bg-transparent text-sm font-bold focus:ring-0"
                        onkeyup="searchMember(this.value)">
                </div>
            </div>

            <div id="memberList" class="space-y-3">

                @forelse($members as $member)

                    <div class="member-item rounded-[1.8rem] bg-lime-50 p-4"
                         data-name="{{ strtolower($member->name) }}"
                         data-code="{{ strtolower($member->member_code) }}"
                         data-nim="{{ strtolower($member->nim ?? '') }}">

                        <div class="flex gap-4">

                            @if ($member->photo)
                                <img src="{{ asset($member->photo) }}"
                                    class="h-16 w-16 rounded-3xl object-cover shadow-lg">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                                    <i data-lucide="user-round" class="h-8 w-8"></i>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-black text-slate-900">
                                            {{ $member->name }}
                                        </h3>

                                        <p class="mt-1 text-xs font-bold text-slate-500">
                                            {{ $member->nim ?? '-' }}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-emerald-700">
                                        {{ $member->member_code }}
                                    </span>

                                </div>

                                <div class="mt-3 flex flex-wrap gap-2">

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        {{ $member->program_study ?? '-' }}
                                    </span>

                                    <span class="rounded-full bg-white px-3 py-1 text-[11px] font-black text-slate-600">
                                        Angkatan {{ $member->class_year ?? '-' }}
                                    </span>

                                    @if($member->status == 'active')
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-black text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-[11px] font-black text-red-600">
                                            Nonaktif
                                        </span>
                                    @endif

                                </div>

                                <div class="mt-4 flex gap-2">

                                    <a href="{{ route('members.show',$member) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-white px-3 py-2 text-xs font-black text-slate-700">
                                        <i data-lucide="eye"></i>
                                        Detail
                                    </a>

                                    <a href="{{ route('members.edit',$member) }}"
                                       class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-lime-200 px-3 py-2 text-xs font-black text-emerald-700">
                                        <i data-lucide="pencil"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('members.destroy',$member) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus anggota ini?')">

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
                        <i data-lucide="users" class="mx-auto h-12 w-12 text-slate-400"></i>

                        <p class="mt-3 text-sm font-black text-slate-500">
                            Belum ada anggota.
                        </p>
                    </div>

                @endforelse

            </div>

            <div class="mt-5">
                {{ $members->links() }}
            </div>

        </div>

    </section>

    <script>
        function searchMember(keyword)
        {
            keyword = keyword.toLowerCase();

            document.querySelectorAll('.member-item').forEach(item => {

                let name = item.dataset.name;
                let code = item.dataset.code;
                let nim = item.dataset.nim;

                if (
                    name.includes(keyword) ||
                    code.includes(keyword) ||
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