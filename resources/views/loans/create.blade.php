<x-app-layout>
    <section class="space-y-6">

        <script src="https://unpkg.com/html5-qrcode"></script>

        <div class="gsap-fade-up flex items-center gap-4">
            <a href="{{ route('loans.index') }}"
               class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-lg">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
            </a>

            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Peminjaman</h2>
                <p class="mt-1 text-sm font-bold text-slate-500">
                    Scan QR anggota lalu pilih buku
                </p>
            </div>
        </div>

        @if (session('error'))
            <div class="rounded-2xl bg-red-100 px-4 py-3 text-sm font-black text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('loans.store') }}" method="POST"
              class="gsap-fade-up space-y-5 rounded-[2rem] bg-white p-5 shadow-xl shadow-emerald-900/5">
            @csrf

            {{-- Scan QR --}}
            <div class="rounded-[2rem] bg-gradient-to-br from-emerald-600 to-lime-400 p-5 text-white">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-black">Scan QR Anggota</h3>
                        <p class="mt-1 text-xs font-bold text-lime-100">
                            Arahkan kamera ke kartu anggota
                        </p>
                    </div>

                    <button type="button"
                            id="startScanBtn"
                            class="rounded-2xl bg-white px-4 py-3 text-xs font-black text-emerald-700">
                        Mulai Scan
                    </button>
                </div>

                <div id="scannerWrapper" class="mt-5 hidden overflow-hidden rounded-[1.5rem] bg-white p-3">
                    <div id="reader" class="overflow-hidden rounded-2xl"></div>
                </div>

                <p id="scanMessage" class="mt-3 hidden rounded-2xl bg-white/20 px-4 py-3 text-xs font-black"></p>
            </div>

            {{-- Data anggota hasil scan --}}
            <div id="selectedMemberCard" class="hidden rounded-[2rem] bg-lime-50 p-4">
                <div class="flex gap-4">
                    <div id="memberPhotoBox"
                         class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-lime-400 text-white">
                        <i data-lucide="user-round" class="h-8 w-8"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-black text-emerald-600" id="memberCodeText">-</p>
                        <h3 class="truncate text-base font-black text-slate-900" id="memberNameText">-</h3>
                        <p class="mt-1 text-xs font-bold text-slate-500" id="memberNimText">-</p>
                        <p class="mt-1 text-xs font-bold text-slate-500" id="memberStudyText">-</p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="member_id" id="member_id" value="{{ old('member_id') }}">

            {{-- Fallback manual kalau kamera gagal --}}
            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">
                    Pilih Anggota Manual
                </label>

                <select id="manualMemberSelect"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <option value="">Pilih anggota jika scan gagal</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                                data-name="{{ $member->name }}"
                                data-code="{{ $member->member_code }}"
                                data-nim="{{ $member->nim }}"
                                data-study="{{ $member->program_study }}"
                                data-year="{{ $member->class_year }}"
                                data-photo="{{ $member->photo ? asset($member->photo) : '' }}">
                            {{ $member->name }} - {{ $member->member_code }}
                        </option>
                    @endforeach
                </select>

                @error('member_id')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Buku</label>
                <select name="book_id"
                        class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                    <option value="">Pilih buku</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>
                            {{ $book->title }} | Stok: {{ $book->available_stock }}
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Tanggal Pinjam</label>
                    <input type="date"
                           name="borrowed_at"
                           value="{{ old('borrowed_at', date('Y-m-d')) }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Tanggal Jatuh Tempo</label>
                    <input type="date"
                           name="due_at"
                           value="{{ old('due_at', now()->addDays(7)->format('Y-m-d')) }}"
                           class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-black text-slate-700">Catatan</label>
                <textarea name="note"
                          rows="4"
                          class="w-full rounded-2xl border-0 bg-lime-50 px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-400"
                          placeholder="Catatan tambahan jika ada">{{ old('note') }}</textarea>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-400 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/25">
                <i data-lucide="save" class="h-5 w-5"></i>
                Simpan Peminjaman
            </button>
        </form>

    </section>

    <script>
        let html5QrCode = null;
        let isScanning = false;

        const startScanBtn = document.getElementById('startScanBtn');
        const scannerWrapper = document.getElementById('scannerWrapper');
        const scanMessage = document.getElementById('scanMessage');

        function showMessage(message, type = 'info') {
            scanMessage.classList.remove('hidden');
            scanMessage.textContent = message;

            if (type === 'error') {
                scanMessage.className = 'mt-3 rounded-2xl bg-red-100 px-4 py-3 text-xs font-black text-red-600';
            } else {
                scanMessage.className = 'mt-3 rounded-2xl bg-white/20 px-4 py-3 text-xs font-black text-white';
            }
        }

        function setMember(member) {
            document.getElementById('member_id').value = member.id;
            document.getElementById('selectedMemberCard').classList.remove('hidden');

            document.getElementById('memberCodeText').textContent = member.member_code;
            document.getElementById('memberNameText').textContent = member.name;
            document.getElementById('memberNimText').textContent = 'NIM: ' + (member.nim ?? '-');
            document.getElementById('memberStudyText').textContent = (member.program_study ?? '-') + ' • Angkatan ' + (member.class_year ?? '-');

            const photoBox = document.getElementById('memberPhotoBox');

            if (member.photo) {
                photoBox.innerHTML = `<img src="${member.photo}" class="h-full w-full object-cover">`;
            } else {
                photoBox.innerHTML = `<i data-lucide="user-round" class="h-8 w-8"></i>`;
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }
        }

        async function findMemberByCode(code) {
            showMessage('Mencari anggota: ' + code);

            try {
                const response = await fetch(`/loans/scan-member/${encodeURIComponent(code)}`, {
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    showMessage(data.message ?? 'Anggota tidak ditemukan.', 'error');
                    return;
                }

                setMember(data.member);
                showMessage('Anggota berhasil ditemukan.');

                if (html5QrCode && isScanning) {
                    await html5QrCode.stop();
                    isScanning = false;
                    scannerWrapper.classList.add('hidden');
                    startScanBtn.textContent = 'Scan Ulang';
                }

            } catch (error) {
                showMessage('Gagal membaca QR anggota.', 'error');
            }
        }

        startScanBtn.addEventListener('click', async function () {
            scannerWrapper.classList.remove('hidden');

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            if (isScanning) {
                await html5QrCode.stop();
                isScanning = false;
                startScanBtn.textContent = 'Mulai Scan';
                scannerWrapper.classList.add('hidden');
                return;
            }

            try {
                await html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    async (decodedText) => {
                        await findMemberByCode(decodedText.trim());
                    }
                );

                isScanning = true;
                startScanBtn.textContent = 'Stop Scan';
                showMessage('Kamera aktif, arahkan ke QR anggota.');

            } catch (error) {
                showMessage('Kamera gagal dibuka. Izinkan akses kamera atau gunakan pilih manual.', 'error');
            }
        });

        document.getElementById('manualMemberSelect').addEventListener('change', function () {
            const option = this.options[this.selectedIndex];

            if (!this.value) return;

            setMember({
                id: this.value,
                name: option.dataset.name,
                member_code: option.dataset.code,
                nim: option.dataset.nim,
                program_study: option.dataset.study,
                class_year: option.dataset.year,
                photo: option.dataset.photo,
            });
        });
    </script>
</x-app-layout>
