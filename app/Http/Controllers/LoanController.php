<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
        public function index()
        {
            Loan::whereIn('status', ['borrowed', 'late'])
                ->whereDate('due_at', '<', now()->toDateString())
                ->update([
                    'status' => 'late',
                ]);

            $loans = Loan::with([
                    'book',
                    'member',
                    'user'
                ])
                ->latest()
                ->paginate(10);

            return view('loans.index', compact('loans'));
        }

    public function create()
    {
        $members = Member::where('status', 'active')
            ->orderBy('name')
            ->get();

        $books = Book::where('available_stock', '>', 0)
            ->orderBy('title')
            ->get();

        return view('loans.create', compact(
            'members',
            'books'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_stock <= 0) {
            return back()->with(
                'error',
                'Stok buku habis.'
            );
        }

        Loan::create([
            'loan_code' => 'PJM-' . time(),
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'borrowed_at' => $request->borrowed_at,
            'due_at' => $request->due_at,
            'status' => 'borrowed',
        ]);

        $book->decrement('available_stock');

        return redirect()
            ->route('loans.index')
            ->with(
                'success',
                'Peminjaman berhasil dibuat.'
            );
    }

    public function show(Loan $loan)
    {
        $loan->load([
            'book',
            'member',
            'user'
        ]);

        return view('loans.show', compact('loan'));
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status == 'borrowed') {

            $loan->book->increment(
                'available_stock'
            );
        }

        $loan->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus.'
        );
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $finePerDay = 1000;
        $today = now()->toDateString();

        $lateDays = 0;

        if ($today > $loan->due_at->toDateString()) {
            $lateDays = $loan->due_at->diffInDays(now());
        }

        $loan->update([
            'returned_at' => now()->toDateString(),
            'status' => 'returned',
            'fine_amount' => $lateDays * $finePerDay,
        ]);

        $loan->book->increment('available_stock');

        return redirect()
            ->route('loans.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }


    public function scanMember($code)
    {
        $member = Member::where('member_code', $code)
            ->where('status', 'active')
            ->first();

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->id,
                'name' => $member->name,
                'member_code' => $member->member_code,
                'nim' => $member->nim,
                'program_study' => $member->program_study,
                'class_year' => $member->class_year,
                'photo' => $member->photo ? asset($member->photo) : null,
            ],
        ]);
    }
}
