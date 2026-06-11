<?php

namespace App\Http\Controllers;

use App\Exports\LoansExport;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function loans(Request $request)
    {
        $query = Loan::with(['book', 'member', 'user'])->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('borrowed_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('borrowed_at', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->paginate(15)->withQueryString();

        $totalLoans = (clone $query)->count();
        $totalFine = (clone $query)->sum('fine_amount');

        return view('reports.loans', compact('loans', 'totalLoans', 'totalFine'));
    }


    public function loansPdf(Request $request)
    {
        $query = Loan::with(['book', 'member', 'user'])->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('borrowed_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('borrowed_at', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->get();
        $totalLoans = $loans->count();
        $totalFine = $loans->sum('fine_amount');

        $pdf = Pdf::loadView('reports.loans-pdf', compact(
            'loans',
            'totalLoans',
            'totalFine'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-peminjaman-ahwaluna.pdf');
    }

    public function loansExcel(Request $request)
    {
        return Excel::download(
            new LoansExport($request),
            'laporan-peminjaman-ahwaluna.xlsx'
        );
    }
}