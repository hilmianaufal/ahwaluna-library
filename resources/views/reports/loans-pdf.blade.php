<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #0f172a;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #16a34a;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #166534;
            margin: 0;
        }

        .subtitle {
            margin-top: 4px;
            color: #475569;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
        }

        .summary td {
            background: #ecfccb;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #16a34a;
            color: white;
            padding: 8px;
            border: 1px solid #15803d;
            font-size: 11px;
        }

        table.data td {
            padding: 8px;
            border: 1px solid #d9f99d;
            vertical-align: top;
            font-size: 10px;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #475569;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1 class="title">Laporan Peminjaman Buku</h1>
        <div class="subtitle">
            Ahwaluna Library - Ma'had Aly Kebon Jambu
        </div>
        <div class="subtitle">
            Dicetak: {{ now()->format('d M Y H:i') }}
        </div>
    </div>

    <table class="summary">
        <tr>
            <td>Total Peminjaman: {{ $totalLoans }}</td>
            <td>Total Denda: Rp {{ number_format($totalFine, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Kode</th>
                <th width="22%">Anggota</th>
                <th width="24%">Buku</th>
                <th width="12%">Pinjam</th>
                <th width="12%">Tempo</th>
                <th width="10%">Status</th>
                <th width="12%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loan->loan_code }}</td>
                    <td>
                        {{ $loan->member->name ?? '-' }}<br>
                        {{ $loan->member->member_code ?? '-' }}
                    </td>
                    <td>
                        {{ $loan->book->title ?? '-' }}<br>
                        {{ $loan->book->code ?? '-' }}
                    </td>
                    <td>{{ $loan->borrowed_at->format('d/m/Y') }}</td>
                    <td>{{ $loan->due_at->format('d/m/Y') }}</td>
                    <td class="status">{{ $loan->status }}</td>
                    <td>Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Petugas Perpustakaan
        <br><br><br>
        ______________________
    </div>

</body>
</html>