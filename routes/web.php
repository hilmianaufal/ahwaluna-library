<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class);
    Route::patch('/loans/{loan}/return', [LoanController::class, 'returnBook'])
    ->name('loans.return');
});


Route::get('/dashboard', function () {
    Loan::whereIn('status', ['borrowed', 'late'])
        ->whereDate('due_at', '<', now()->toDateString())
        ->update(['status' => 'late']);

    $monthlyLoans = Loan::select(
            DB::raw('MONTH(borrowed_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('borrowed_at', now()->year)
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    $chartData = [];

    for ($i = 1; $i <= 12; $i++) {
        $chartData[] = $monthlyLoans[$i] ?? 0;
    }

    return view('dashboard', [
        'totalBooks' => Book::count(),
        'totalMembers' => Member::count(),
        'totalBorrowed' => Loan::where('status', 'borrowed')->count(),
        'totalAvailableBooks' => Book::sum('available_stock'),
        'totalRepositories' => Repository::count(),
        'monthlyFine' => Loan::whereMonth('returned_at', now()->month)
            ->whereYear('returned_at', now()->year)
            ->sum('fine_amount'),
        'latestBooks' => Book::with(['category', 'shelf'])->latest()->take(5)->get(),
        'chartData' => $chartData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('categories', CategoryController::class);
});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('loans', LoanController::class);
    Route::resource('shelves', ShelfController::class);
    Route::get('/books/{book}/qr', [BookController::class, 'qr'])
    ->name('books.qr');
    Route::resource('repositories', RepositoryController::class);
    Route::get('/repositories/{repository}/download', [RepositoryController::class, 'download'])
    ->name('repositories.download');
    Route::get('/reports/loans', [ReportController::class, 'loans'])
    ->name('reports.loans');
    Route::get('/reports/loans/pdf', [ReportController::class, 'loansPdf'])
    ->name('reports.loans.pdf');
    Route::get('/reports/loans/excel', [ReportController::class, 'loansExcel'])
    ->name('reports.loans.excel');
    Route::get(
    '/members/{member}/card',
    [MemberController::class, 'card']
)->name('members.card');

Route::get('/loans/scan-member/{code}', [LoanController::class, 'scanMember'])
    ->name('loans.scan-member');

    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
