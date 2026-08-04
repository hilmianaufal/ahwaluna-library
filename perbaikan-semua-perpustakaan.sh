#!/usr/bin/env bash
set -euo pipefail

if [ ! -f "artisan" ]; then
    echo "ERROR: Jalankan script ini dari folder utama project Laravel."
    exit 1
fi

BACKUP_DIR="backup-perbaikan-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR/app/Http/Controllers/Auth"
mkdir -p "$BACKUP_DIR/app/Http/Controllers"

cp app/Http/Controllers/LoanController.php "$BACKUP_DIR/app/Http/Controllers/LoanController.php"
cp app/Http/Controllers/BookController.php "$BACKUP_DIR/app/Http/Controllers/BookController.php"
cp app/Http/Controllers/MemberController.php "$BACKUP_DIR/app/Http/Controllers/MemberController.php"
cp app/Http/Controllers/Auth/RegisteredUserController.php "$BACKUP_DIR/app/Http/Controllers/Auth/RegisteredUserController.php"

echo "Backup dibuat di: $BACKUP_DIR"

cat > app/Http/Controllers/LoanController.php <<'PHP'
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
PHP

cat > app/Http/Controllers/BookController.php <<'PHP'
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
PHP

cat > app/Http/Controllers/MemberController.php <<'PHP'
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
PHP

cat > app/Http/Controllers/Auth/RegisteredUserController.php <<'PHP'
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasantri',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('mahasantri.dashboard');
    }
}
PHP

if ! find database/migrations -maxdepth 1 -type f \
    -name "*_add_unique_user_id_to_members_table.php" | grep -q .; then

    MIGRATION_FILE="database/migrations/$(date +%Y_%m_%d_%H%M%S)_add_unique_user_id_to_members_table.php"

    cat > "$MIGRATION_FILE" <<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateUserIds = DB::table('members')
            ->select('user_id')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id');

        if ($duplicateUserIds->isNotEmpty()) {
            throw new RuntimeException(
                'Migrasi dibatalkan. Ada user_id anggota yang terhubung ke lebih dari satu anggota: '
                . $duplicateUserIds->implode(', ')
            );
        }

        Schema::table('members', function (Blueprint $table) {
            $table->unique('user_id', 'members_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropUnique('members_user_id_unique');
        });
    }
};
PHP

    echo "Migration dibuat: $MIGRATION_FILE"
else
    echo "Migration unique user_id sudah ditemukan, tidak membuat migration baru."
fi

echo ""
echo "Memeriksa syntax PHP..."

php -l app/Http/Controllers/LoanController.php
php -l app/Http/Controllers/BookController.php
php -l app/Http/Controllers/MemberController.php
php -l app/Http/Controllers/Auth/RegisteredUserController.php

LATEST_MIGRATION="$(find database/migrations -maxdepth 1 -type f \
    -name "*_add_unique_user_id_to_members_table.php" | sort | tail -n 1)"

if [ -n "$LATEST_MIGRATION" ]; then
    php -l "$LATEST_MIGRATION"
fi

php artisan optimize:clear

echo ""
echo "Perbaikan file selesai."
echo "Backup: $BACKUP_DIR"
echo ""
echo "Langkah berikutnya:"
echo "1. Cek duplikasi user anggota."
echo "2. Jalankan: php artisan migrate"
echo "3. Uji peminjaman, pengembalian, hapus pinjaman terlambat, buku, dan anggota."
