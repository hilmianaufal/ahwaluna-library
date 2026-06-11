<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        $shelves = Shelf::withCount('books')->latest()->paginate(10);

        return view('shelves.index', compact('shelves'));
    }

    public function create()
    {
        return view('shelves.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'max:50', 'unique:shelves,code'],
            'name' => ['required', 'max:255'],
            'location' => ['nullable', 'max:255'],
        ]);

        Shelf::create($data);

        return redirect()
            ->route('shelves.index')
            ->with('success', 'Rak buku berhasil ditambahkan.');
    }

    public function edit(Shelf $shelf)
    {
        return view('shelves.edit', compact('shelf'));
    }

    public function update(Request $request, Shelf $shelf)
    {
        $data = $request->validate([
            'code' => ['required', 'max:50', 'unique:shelves,code,' . $shelf->id],
            'name' => ['required', 'max:255'],
            'location' => ['nullable', 'max:255'],
        ]);

        $shelf->update($data);

        return redirect()
            ->route('shelves.index')
            ->with('success', 'Rak buku berhasil diperbarui.');
    }

    public function destroy(Shelf $shelf)
    {
        $shelf->delete();

        return back()->with('success', 'Rak buku berhasil dihapus.');
    }
}