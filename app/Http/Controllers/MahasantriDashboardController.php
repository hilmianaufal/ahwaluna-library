<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Repository;
use Illuminate\Support\Facades\Auth;

class MahasantriDashboardController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;

        return view('mahasantri.dashboard', [
            'member' => $member,
            'activeLoans' => $member?->loans()
                ->with('book')
                ->whereIn('status', ['borrowed', 'late'])
                ->latest()
                ->get() ?? collect(),

            'latestBooks' => Book::with(['category', 'shelf'])
                ->latest()
                ->take(5)
                ->get(),

            'latestRepositories' => Repository::latest()
                ->take(5)
                ->get(),
        ]);
    }
    public function catalog()
    {
        $books = \App\Models\Book::with(['category', 'shelf'])
            ->latest()
            ->paginate(12);

        return view('mahasantri.catalog', compact('books'));
    }

    public function card()
{
    $member = auth()->user()->member;

    if (! $member) {
        return redirect()
            ->route('mahasantri.dashboard')
            ->with('error', 'Akun belum terhubung dengan anggota.');
    }

    return view('mahasantri.card', compact('member'));
}

    public function bookDetail(\App\Models\Book $book)
    {
        $book->load(['category', 'shelf']);

        return view('mahasantri.book-detail', compact('book'));
    }

    public function repositories()
    {
        $repositories = \App\Models\Repository::latest()
            ->paginate(10);

        return view('mahasantri.repositories', compact('repositories'));
    }
}
