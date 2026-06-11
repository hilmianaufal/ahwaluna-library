<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:categories,name'],
            'icon' => ['nullable', 'max:100'],
            'description' => ['nullable'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['icon'] = $data['icon'] ?: 'book-open';

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:categories,name,' . $category->id],
            'icon' => ['nullable', 'max:100'],
            'description' => ['nullable'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['icon'] = $data['icon'] ?: 'book-open';

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}