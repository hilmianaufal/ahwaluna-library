<?php

namespace App\Exports;

use App\Models\Loan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoansExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Loan::with(['book', 'member', 'user'])->latest();

        if ($this->request->filled('start_date')) {
            $query->whereDate('borrowed_at', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('borrowed_at', '<=', $this->request->end_date);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->get()->map(function ($loan) {
            return [
                'Kode' => $loan->loan_code,
                'Anggota' => $loan->member->name ?? '-',
                'Kode Anggota' => $loan->member->member_code ?? '-',
                'Buku' => $loan->book->title ?? '-',
                'Kode Buku' => $loan->book->code ?? '-',
                'Tanggal Pinjam' => $loan->borrowed_at?->format('d/m/Y'),
                'Jatuh Tempo' => $loan->due_at?->format('d/m/Y'),
                'Tanggal Kembali' => $loan->returned_at?->format('d/m/Y') ?? '-',
                'Status' => strtoupper($loan->status),
                'Denda' => $loan->fine_amount,
                'Petugas' => $loan->user->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Anggota',
            'Kode Anggota',
            'Buku',
            'Kode Buku',
            'Tanggal Pinjam',
            'Jatuh Tempo',
            'Tanggal Kembali',
            'Status',
            'Denda',
            'Petugas',
        ];
    }
}