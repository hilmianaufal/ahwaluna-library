<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'shelf'])
            ->latest()
            ->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $shelves = Shelf::orderBy('code')->get();

        return view('books.create', compact('categories', 'shelves'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'shelf_id' => ['nullable', 'exists:shelves,id'],
            'title' => ['required', 'max:255'],
            'author' => ['nullable', 'max:255'],
            'publisher' => ['nullable', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'isbn' => ['nullable', 'max:255'],
            'stock' => ['required', 'integer', 'min:1'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        do {
            $code = 'BK-' . strtoupper(Str::random(6));
        } while (Book::where('code', $code)->exists());

        $data['code'] = $code;
        $data['available_stock'] = $data['stock'];
        $data['is_digital'] = false;
        $data['can_borrow'] = true;

        $newCoverPath = null;

        if ($request->hasFile('cover')) {
            $uploadDirectory = public_path('uploads/books');

            if (! file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDirectory, $filename);

            $newCoverPath = 'uploads/books/' . $filename;
            $data['cover'] = $newCoverPath;
        }

        try {
            Book::create($data);
        } catch (\Throwable $exception) {
            if ($newCoverPath && file_exists(public_path($newCoverPath))) {
                unlink(public_path($newCoverPath));
            }

            throw $exception;
        }

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'shelf']);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $shelves = Shelf::orderBy('code')->get();

        return view('books.edit', compact('book', 'categories', 'shelves'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'shelf_id' => ['nullable', 'exists:shelves,id'],
            'title' => ['required', 'max:255'],
            'author' => ['nullable', 'max:255'],
            'publisher' => ['nullable', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'isbn' => ['nullable', 'max:255'],
            'stock' => ['required', 'integer', 'min:1'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $activeLoanCount = $book->loans()
            ->whereIn('status', ['borrowed', 'late'])
            ->count();

        if ((int) $data['stock'] < $activeLoanCount) {
            return back()
                ->withInput()
                ->withErrors([
                    'stock' => "Stok tidak boleh kurang dari {$activeLoanCount}, karena masih ada buku yang sedang dipinjam.",
                ]);
        }

        $data['available_stock'] = (int) $data['stock'] - $activeLoanCount;

        $oldCoverPath = $book->cover;
        $newCoverPath = null;

        if ($request->hasFile('cover')) {
            $uploadDirectory = public_path('uploads/books');

            if (! file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDirectory, $filename);

            $newCoverPath = 'uploads/books/' . $filename;
            $data['cover'] = $newCoverPath;
        }

        try {
            $book->update($data);
        } catch (\Throwable $exception) {
            if ($newCoverPath && file_exists(public_path($newCoverPath))) {
                unlink(public_path($newCoverPath));
            }

            throw $exception;
        }

        if (
            $newCoverPath
            && $oldCoverPath
            && $oldCoverPath !== $newCoverPath
            && file_exists(public_path($oldCoverPath))
        ) {
            unlink(public_path($oldCoverPath));
        }

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->exists()) {
            return back()->with(
                'error',
                'Buku tidak dapat dihapus karena sudah memiliki riwayat peminjaman.'
            );
        }

        $coverPath = $book->cover;

        $book->delete();

        if ($coverPath && file_exists(public_path($coverPath))) {
            unlink(public_path($coverPath));
        }

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    public function qr(Book $book)
    {
        return view('books.qr', compact('book'));
    }
}
