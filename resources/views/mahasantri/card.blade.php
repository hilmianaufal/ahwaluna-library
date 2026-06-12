<x-mahasantri-layout>

    <section class="card-wrap space-y-5">

        <div class="flex items-center justify-between">
            <a href="{{ route('mahasantri.dashboard') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left"></i>
            </a>

            <button onclick="downloadCard()"
                    class="rounded-2xl bg-gradient-to-r from-emerald-600 to-lime-400 px-5 py-3 text-sm font-black text-white shadow-lg">
                Download
            </button>
        </div>

        @include('members.partials.card')

    </section>

</x-mahasantri-layout>
