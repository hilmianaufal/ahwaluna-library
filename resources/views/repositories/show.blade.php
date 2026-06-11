<x-app-layout>
    <section class="space-y-6">

        <div class="gsap-fade-up flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('repositories.index') }}"
                   class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                    <i data-lucide="arrow-left" class="h-5 w-5"></i>
                </a>

                <div>
                    <h2 class="text-2xl font-black text-slate-900">Detail Repository</h2>
                    <p class="mt-1 text-sm font-bold text-slate-500">
                        Informasi karya ilmiah
                    </p>
                </div>
            </div>

            <a href="{{ route('repositories.edit', $repository) }}"
               class="rounded-2xl bg-lime-100 px-4 py-3 text-sm font-black text-emerald-700">
                Edit
            </a>
        </div>

        @if (session('error'))
            <div class="rounded-2xl bg-red-100 px-4 py-3 text-sm font-black text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <div class="gsap-fade-up overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-emerald-900/5">

            <div class="bg-gradient-to-br from-emerald-500 to-lime-400 p-6 text-white">
                <div class="flex gap-5">
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[2rem] bg-white/20 backdrop-blur">
                        <i data-lucide="graduation-cap" class="h-12 w-12"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-black text-lime-100">
                            {{ strtoupper($repository->type) }}
                        </p>

                        <h3 class="mt-1 text-2xl font-black leading-tight">
                            {{ $repository->title }}
                        </h3>

                        <p class="mt-2 text-sm font-bold text-emerald-50">
                            {{ $repository->author }} • {{ $repository->year ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 p-5 md:grid-cols-2">
                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Penulis</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $repository->author }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">NIM</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $repository->nim ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Pembimbing</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $repository->supervisor ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Tahun</p>
                    <p class="mt-1 text-sm font-black text-slate-800">
                        {{ $repository->year ?? '-' }}
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Dilihat</p>
                    <p class="mt-1 text-sm font-black text-emerald-700">
                        {{ $repository->view_count }} kali
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4">
                    <p class="text-xs font-black text-slate-400">Download</p>
                    <p class="mt-1 text-sm font-black text-emerald-700">
                        {{ $repository->download_count }} kali
                    </p>
                </div>

                <div class="rounded-3xl bg-lime-50 p-4 md:col-span-2">
                    <p class="text-xs font-black text-slate-400">Abstrak</p>
                    <p class="mt-2 text-sm font-bold leading-relaxed text-slate-700">
                        {{ $repository->abstract ?? 'Belum ada abstrak.' }}
                    </p>
                </div>
            </div>

            @if ($repository->pdf_file)
                <div class="grid gap-3 p-5 pt-0 md:grid-cols-2">
                    <a href="{{ asset($repository->pdf_file) }}" target="_blank"
                       class="flex items-center justify-center gap-2 rounded-2xl bg-lime-100 px-5 py-4 text-sm font-black text-emerald-700">
                        <i data-lucide="book-open" class="h-5 w-5"></i>
                        Baca PDF
                    </a>

                    <a href="{{ route('repositories.download', $repository) }}"
                       class="flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                        <i data-lucide="download" class="h-5 w-5"></i>
                        Download PDF
                    </a>
                </div>
            @endif

        </div>

    </section>
</x-app-layout>