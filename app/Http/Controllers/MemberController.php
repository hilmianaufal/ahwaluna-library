<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

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
            'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $lastId = Member::max('id') + 1;

        $data['member_code'] = 'AGT-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('photo')) {

            if (! file_exists(public_path('uploads/members'))) {
                mkdir(public_path('uploads/members'), 0777, true);
            }

            $file = $request->file('photo');

            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/members'),
                $filename
            );

            $data['photo'] = 'uploads/members/'.$filename;
        }

        Member::create($data);

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
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

            if ($request->hasFile('photo')) {
                if (!file_exists(public_path('uploads/members'))) {
                    mkdir(public_path('uploads/members'), 0777, true);
                }

                if ($member->photo && file_exists(public_path($member->photo))) {
                    unlink(public_path($member->photo));
                }

                $file = $request->file('photo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/members'), $filename);

                $data['photo'] = 'uploads/members/' . $filename;
            }
        $member->update($data);

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }


    public function card(Member $member)
    {
        return view(
            'members.card',
            compact('member')
        );
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
