<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index()
    {
        Loan::where('status', 'borrowed')
            ->whereDate('due_at', '<', now()->toDateString())
            ->update([
                'status' => 'late',
            ]);

        $loans = Loan::with([
                'book',
                'member',
                'user',
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

        return view('loans.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => ['required', 'exists:books,id'],
            'borrowed_at' => ['required', 'date'],
            'due_at' => ['required', 'date', 'after_or_equal:borrowed_at'],
        ]);

        DB::transaction(function () use ($data) {
            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($data['book_id']);

            if ((int) $book->available_stock <= 0) {
                throw ValidationException::withMessages([
                    'book_id' => 'Stok buku habis.',
                ]);
            }

            do {
                $loanCode = 'PJM-'
                    . now()->format('YmdHis')
                    . '-'
                    . strtoupper(Str::random(4));
            } while (Loan::where('loan_code', $loanCode)->exists());

            Loan::create([
                'loan_code' => $loanCode,
                'member_id' => $data['member_id'],
                'book_id' => $data['book_id'],
                'user_id' => Auth::id(),
                'borrowed_at' => $data['borrowed_at'],
                'due_at' => $data['due_at'],
                'status' => 'borrowed',
                'fine_amount' => 0,
            ]);

            $book->available_stock = max(
                0,
                (int) $book->available_stock - 1
            );

            $book->save();
        });

        return redirect()
            ->route('loans.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function show(Loan $loan)
    {
        $loan->load([
            'book',
            'member',
            'user',
        ]);

        return view('loans.show', compact('loan'));
    }

    public function destroy(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            $lockedLoan = Loan::query()
                ->lockForUpdate()
                ->findOrFail($loan->id);

            if (in_array($lockedLoan->status, ['borrowed', 'late'], true)) {
                $book = Book::query()
                    ->lockForUpdate()
                    ->findOrFail($lockedLoan->book_id);

                $book->available_stock = min(
                    (int) $book->stock,
                    (int) $book->available_stock + 1
                );

                $book->save();
            }

            $lockedLoan->delete();
        });

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function returnBook(Loan $loan)
    {
        $result = DB::transaction(function () use ($loan) {
            $lockedLoan = Loan::query()
                ->lockForUpdate()
                ->findOrFail($loan->id);

            if ($lockedLoan->status === 'returned') {
                return false;
            }

            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($lockedLoan->book_id);

            $today = now()->startOfDay();
            $dueDate = $lockedLoan->due_at->copy()->startOfDay();

            $lateDays = $today->greaterThan($dueDate)
                ? $dueDate->diffInDays($today)
                : 0;

            $lockedLoan->update([
                'returned_at' => $today->toDateString(),
                'status' => 'returned',
                'fine_amount' => $lateDays * 1000,
            ]);

            $book->available_stock = min(
                (int) $book->stock,
                (int) $book->available_stock + 1
            );

            $book->save();

            return true;
        });

        if (! $result) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        return redirect()
            ->route('loans.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }

    public function scanMember(string $code)
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
