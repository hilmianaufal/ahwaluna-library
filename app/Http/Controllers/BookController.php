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

        $data['code'] = 'BK-' . strtoupper(Str::random(6));
        $data['available_stock'] = $data['stock'];
        $data['is_digital'] = false;
        $data['can_borrow'] = true;
        if ($request->hasFile('cover')) {
            if (!file_exists(public_path('uploads/books'))) {
                mkdir(public_path('uploads/books'), 0777, true);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/books'), $filename);

            $data['cover'] = 'uploads/books/' . $filename;
        }
        Book::create($data);

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

        $difference = $data['stock'] - $book->stock;
        $data['available_stock'] = max(0, $book->available_stock + $difference);

        if ($request->hasFile('cover')) {
            if (!file_exists(public_path('uploads/books'))) {
                mkdir(public_path('uploads/books'), 0777, true);
            }

            if ($book->cover && file_exists(public_path($book->cover))) {
                unlink(public_path($book->cover));
            }

            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/books'), $filename);

            $data['cover'] = 'uploads/books/' . $filename;
        }

        $book->update($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    public function qr(Book $book)
    {
        return view('books.qr', compact('book'));
    }
}