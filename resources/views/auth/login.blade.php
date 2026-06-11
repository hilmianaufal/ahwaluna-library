<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ahwaluna Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-lime-50">

<section class="flex min-h-screen items-center justify-center px-5 py-8">
    <div class="grid w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-emerald-900/10 md:grid-cols-2">

        <div class="hidden bg-gradient-to-br from-emerald-950 via-emerald-700 to-lime-500 p-10 text-white md:block">
            <div class="flex h-24 w-24 items-center justify-center rounded-[2rem] border-4 border-yellow-400 bg-white p-3 shadow-2xl">
                <img src="{{ asset('logo-ahwaluna.png') }}" class="h-full w-full object-contain">
            </div>

            <h1 class="mt-8 text-4xl font-black leading-tight">
                Ahwaluna<br>Library
            </h1>

            <p class="mt-4 max-w-sm text-sm font-semibold leading-relaxed text-lime-50">
                Sistem perpustakaan digital Ma'had Aly Kebon Jambu untuk mengelola buku, anggota, peminjaman, repository, dan karya ilmiah.
            </p>
        </div>

        <div class="p-8 md:p-12">
            <div class="mb-8 text-center md:hidden">
                <img src="{{ asset('logo-ahwaluna.png') }}" class="mx-auto h-24 w-24 object-contain">
                <h1 class="mt-4 text-3xl font-black text-slate-900">Ahwaluna</h1>
                <p class="text-sm font-bold text-emerald-600">Library System</p>
            </div>

            <p class="text-sm font-black tracking-[0.25em] text-emerald-600">AHWALUNA LIBRARY</p>
            <h2 class="mt-2 text-3xl font-black text-slate-900">Login Admin</h2>
            <p class="mt-2 text-sm font-bold text-slate-500">Masuk untuk mengelola sistem perpustakaan.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    @error('password')
                        <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                    Masuk Dashboard
                </button>
            </form>
        </div>

    </div>
</section>

</body>
</html>