<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index()
    {
        $repositories = Repository::latest()->paginate(10);

        return view('repositories.index', compact('repositories'));
    }

    public function create()
    {
        return view('repositories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'nim' => ['nullable', 'max:100'],
            'supervisor' => ['nullable', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'type' => ['required', 'max:100'],
            'abstract' => ['nullable'],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('pdf_file')) {
            if (!file_exists(public_path('uploads/repositories'))) {
                mkdir(public_path('uploads/repositories'), 0777, true);
            }

            $file = $request->file('pdf_file');
            $filename = time() . '_' . uniqid() . '.pdf';

            $file->move(public_path('uploads/repositories'), $filename);

            $data['pdf_file'] = 'uploads/repositories/' . $filename;
        }

        Repository::create($data);

        return redirect()
            ->route('repositories.index')
            ->with('success', 'Repository berhasil ditambahkan.');
    }

    public function show(Repository $repository)
    {
        $repository->increment('view_count');

        return view('repositories.show', compact('repository'));
    }

    public function edit(Repository $repository)
    {
        return view('repositories.edit', compact('repository'));
    }

    public function update(Request $request, Repository $repository)
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'nim' => ['nullable', 'max:100'],
            'supervisor' => ['nullable', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'type' => ['required', 'max:100'],
            'abstract' => ['nullable'],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('pdf_file')) {
            if (!file_exists(public_path('uploads/repositories'))) {
                mkdir(public_path('uploads/repositories'), 0777, true);
            }

            if ($repository->pdf_file && file_exists(public_path($repository->pdf_file))) {
                unlink(public_path($repository->pdf_file));
            }

            $file = $request->file('pdf_file');
            $filename = time() . '_' . uniqid() . '.pdf';

            $file->move(public_path('uploads/repositories'), $filename);

            $data['pdf_file'] = 'uploads/repositories/' . $filename;
        }

        $repository->update($data);

        return redirect()
            ->route('repositories.index')
            ->with('success', 'Repository berhasil diperbarui.');
    }

        public function download(Repository $repository)
        {
            if (! $repository->pdf_file || ! file_exists(public_path($repository->pdf_file))) {
                return back()->with('error', 'File PDF tidak ditemukan.');
            }

            $repository->increment('download_count');

            return response()->download(public_path($repository->pdf_file));
        }

    public function destroy(Repository $repository)
    {
        if ($repository->pdf_file && file_exists(public_path($repository->pdf_file))) {
            unlink(public_path($repository->pdf_file));
        }

        $repository->delete();

        return back()->with('success', 'Repository berhasil dihapus.');
    }
}