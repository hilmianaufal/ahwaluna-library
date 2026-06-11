<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\Shelf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiqih', 'icon' => 'scale'],
            ['name' => 'Ushul Fiqih', 'icon' => 'landmark'],
            ['name' => 'Tafsir', 'icon' => 'book-open'],
            ['name' => 'Hadits', 'icon' => 'scroll-text'],
            ['name' => 'Bahasa Arab', 'icon' => 'languages'],
            ['name' => 'Kitab Turats', 'icon' => 'library'],
            ['name' => 'Jurnal', 'icon' => 'newspaper'],
            ['name' => 'Skripsi', 'icon' => 'graduation-cap'],
        ];

        foreach ($categories as $item) {
            Category::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'icon' => $item['icon'],
                'description' => 'Koleksi buku kategori '.$item['name'],
            ]);
        }

        $shelves = [
            ['code' => 'A1', 'name' => 'Rak Fiqih', 'location' => 'Lantai 1'],
            ['code' => 'A2', 'name' => 'Rak Tafsir', 'location' => 'Lantai 1'],
            ['code' => 'B1', 'name' => 'Rak Hadits', 'location' => 'Lantai 1'],
            ['code' => 'B2', 'name' => 'Rak Bahasa Arab', 'location' => 'Lantai 2'],
            ['code' => 'C1', 'name' => 'Rak Skripsi', 'location' => 'Lantai 2'],
        ];

        foreach ($shelves as $shelf) {
            Shelf::create($shelf);
        }

        $books = [
            ['title' => 'Fathul Muin', 'author' => 'Zainuddin Al-Malibari', 'category' => 'Fiqih', 'shelf' => 'A1'],
            ['title' => 'Fathul Qarib', 'author' => 'Ibnu Qasim Al-Ghazi', 'category' => 'Fiqih', 'shelf' => 'A1'],
            ['title' => 'Tafsir Jalalain', 'author' => 'Jalaluddin Al-Mahalli & Jalaluddin As-Suyuthi', 'category' => 'Tafsir', 'shelf' => 'A2'],
            ['title' => 'Bulughul Maram', 'author' => 'Ibnu Hajar Al-Asqalani', 'category' => 'Hadits', 'shelf' => 'B1'],
            ['title' => 'Alfiyah Ibnu Malik', 'author' => 'Ibnu Malik', 'category' => 'Bahasa Arab', 'shelf' => 'B2'],
            ['title' => 'Ihya Ulumuddin', 'author' => 'Imam Al-Ghazali', 'category' => 'Kitab Turats', 'shelf' => 'A1'],
            ['title' => 'Bidayatul Mujtahid', 'author' => 'Ibnu Rusyd', 'category' => 'Ushul Fiqih', 'shelf' => 'A1'],
            ['title' => 'Metodologi Penelitian Islam', 'author' => 'Tim Akademik', 'category' => 'Skripsi', 'shelf' => 'C1'],
        ];

        foreach ($books as $index => $book) {
            $category = Category::where('name', $book['category'])->first();
            $shelf = Shelf::where('code', $book['shelf'])->first();

            Book::create([
                'category_id' => $category?->id,
                'shelf_id' => $shelf?->id,
                'code' => 'BK-'.str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'title' => $book['title'],
                'author' => $book['author'],
                'publisher' => 'Maktabah Ahwaluna',
                'year' => 2024,
                'isbn' => null,
                'stock' => 5,
                'available_stock' => 5,
                'is_digital' => false,
                'can_borrow' => true,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            Member::create([
                'member_code' => 'AGT-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Mahasantri '.$i,
                'nim' => 'MA'.date('Y').str_pad($i, 3, '0', STR_PAD_LEFT),
                'program_study' => 'Fiqih dan Ushul Fiqih',
                'class_year' => '2024',
                'phone' => '08'.rand(1111111111, 9999999999),
                'status' => 'active',
            ]);
        }
    }
}