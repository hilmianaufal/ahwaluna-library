<x-app-layout>

<section class="max-w-md mx-auto">

    <div class="rounded-[2rem] bg-white p-8 shadow-xl shadow-emerald-900/10">

        <h2 class="text-center text-2xl font-black text-slate-900">
            QR Buku
        </h2>

        <p class="mt-2 text-center text-sm font-bold text-slate-500">
            {{ $book->title }}
        </p>

        <div class="mt-8 flex justify-center">

            {!! QrCode::size(250)->generate(
                route('books.show',$book)
            ) !!}

        </div>

        <div class="mt-6 text-center">

            <p class="font-black text-slate-700">
                {{ $book->code }}
            </p>

        </div>

    </div>

</section>

</x-app-layout>