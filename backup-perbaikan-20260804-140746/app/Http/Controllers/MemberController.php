<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $users = User::where('role', 'mahasantri')
            ->whereDoesntHave('member')
            ->orderBy('name')
            ->get();

        return view('members.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'nim' => ['nullable', 'max:100'],
            'program_study' => ['nullable', 'max:255'],
            'class_year' => ['nullable', 'max:20'],
            'phone' => ['nullable', 'max:30'],
            'status' => ['required', 'in:active,inactive'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('role', 'mahasantri')
                ),
                Rule::unique('members', 'user_id'),
            ],
        ]);

        $lastId = ((int) Member::max('id')) + 1;
        $data['member_code'] = 'AGT-' . str_pad((string) $lastId, 4, '0', STR_PAD_LEFT);

        $newPhotoPath = null;

        if ($request->hasFile('photo')) {
            $uploadDirectory = public_path('uploads/members');

            if (! file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDirectory, $filename);

            $newPhotoPath = 'uploads/members/' . $filename;
            $data['photo'] = $newPhotoPath;
        }

        try {
            Member::create($data);
        } catch (\Throwable $exception) {
            if ($newPhotoPath && file_exists(public_path($newPhotoPath))) {
                unlink(public_path($newPhotoPath));
            }

            throw $exception;
        }

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $member->load('loans.book');

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $users = User::where('role', 'mahasantri')
            ->where(function ($query) use ($member) {
                $query->whereDoesntHave('member');

                if ($member->user_id) {
                    $query->orWhere('id', $member->user_id);
                }
            })
            ->orderBy('name')
            ->get();

        return view('members.edit', compact('member', 'users'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'nim' => ['nullable', 'max:100'],
            'program_study' => ['nullable', 'max:255'],
            'class_year' => ['nullable', 'max:20'],
            'phone' => ['nullable', 'max:30'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('role', 'mahasantri')
                ),
                Rule::unique('members', 'user_id')->ignore($member->id),
            ],
        ]);

        $oldPhotoPath = $member->photo;
        $newPhotoPath = null;

        if ($request->hasFile('photo')) {
            $uploadDirectory = public_path('uploads/members');

            if (! file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDirectory, $filename);

            $newPhotoPath = 'uploads/members/' . $filename;
            $data['photo'] = $newPhotoPath;
        }

        try {
            $member->update($data);
        } catch (\Throwable $exception) {
            if ($newPhotoPath && file_exists(public_path($newPhotoPath))) {
                unlink(public_path($newPhotoPath));
            }

            throw $exception;
        }

        if (
            $newPhotoPath
            && $oldPhotoPath
            && $oldPhotoPath !== $newPhotoPath
            && file_exists(public_path($oldPhotoPath))
        ) {
            unlink(public_path($oldPhotoPath));
        }

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    public function card(Member $member)
    {
        return view('members.card', compact('member'));
    }

    public function destroy(Member $member)
    {
        if ($member->loans()->exists()) {
            return back()->with(
                'error',
                'Anggota tidak dapat dihapus karena sudah memiliki riwayat peminjaman.'
            );
        }

        $photoPath = $member->photo;

        $member->delete();

        if ($photoPath && file_exists(public_path($photoPath))) {
            unlink(public_path($photoPath));
        }

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
