<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DAFTAR BUKU POPULER (Tetap dipertahankan)
        $popularBooks = [
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '9781847941831',
                'status' => 'Tersedia',
                'category_id' => 2,
                'image' => 'covers/atomic_habits.jpg',
                'description' => 'Perubahan kecil yang memberikan hasil luar biasa.'
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'isbn' => '9780857197689',
                'status' => 'Tersedia',
                'category_id' => 2,
                'image' => 'covers/The-Psychology-of-Money.jpg',
                'description' => 'Memahami bagaimana perilaku manusia terhadap uang.'
            ],
        ];

        // 2. DAFTAR BUKU PER KATEGORI (Ditambah koleksi baru)
        $categoryBooks = [
            // Kategori: FIKSI (ID: 1)
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789793062791',
                'status' => 'Tersedia',
                'category_id' => 1,
                'image' => 'covers/Laskar_Pelangi.jpg',
                'description' => 'Kisah perjuangan anak-anak Belitung mengejar pendidikan.'
            ],
            [
                'title' => 'Bumi',
                'author' => 'Tere Liye',
                'isbn' => '9786020303017',
                'status' => 'Tersedia',
                'category_id' => 1,
                'image' => 'covers/Bumi_Tere_Liye.jpg',
                'description' => 'Petualangan dunia paralel tiga remaja luar biasa.'
            ],
            [
                'title' => 'Hujan',
                'author' => 'Tere Liye',
                'isbn' => '9786020332918',
                'status' => 'Tersedia',
                'category_id' => 1,
                'image' => 'covers/Hujan.jpg',
                'description' => 'Tentang persahabatan, cinta, dan melupakan.'
            ],

            // Kategori: BISNIS (ID: 2) - Tambahan baru
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'isbn' => '9781612680194',
                'status' => 'Tersedia',
                'category_id' => 2,
                'image' => 'covers/rich_dad.jpg',
                'description' => 'Pelajaran finansial yang tidak diajarkan di sekolah.'
            ],
            [
                'title' => 'Zero to One',
                'author' => 'Peter Thiel',
                'isbn' => '9780804139298',
                'status' => 'Tersedia',
                'category_id' => 2,
                'image' => 'covers/zero_to_one.jpg',
                'description' => 'Membangun masa depan melalui inovasi startup.'
            ],

            // Kategori: TEKNOLOGI (ID: 3)
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'status' => 'Tersedia',
                'category_id' => 3,
                'image' => 'covers/clean_code.jpg',
                'description' => 'Alkitab bagi para programmer untuk menulis kode yang rapi.'
            ],
            [
                'title' => 'Pragmatic Programmer',
                'author' => 'Andrew Hunt',
                'isbn' => '9780135957059',
                'status' => 'Tersedia',
                'category_id' => 3,
                'image' => 'covers/pragmatic.jpg',
                'description' => 'Tips menjadi software developer profesional.'
            ],
            [
                'title' => 'The Phoenix Project',
                'author' => 'Gene Kim',
                'isbn' => '9780988262591',
                'status' => 'Tersedia',
                'category_id' => 3,
                'image' => 'covers/phoenix_project.jpg',
                'description' => 'Novel tentang IT, DevOps, dan kesuksesan bisnis.'
            ],

            // Kategori: SEJARAH (ID: 4)
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'status' => 'Tersedia',
                'category_id' => 4,
                'image' => 'covers/Sapiens.jpg',
                'description' => 'Sejarah singkat umat manusia.'
            ],
            [
                'title' => 'Guns, Germs, and Steel',
                'author' => 'Jared Diamond',
                'isbn' => '9780393038910',
                'status' => 'Tersedia',
                'category_id' => 4,
                'image' => 'covers/guns_germs.jpg',
                'description' => 'Bagaimana lingkungan membentuk sejarah dunia.'
            ],
            [
                'title' => 'Homo Deus',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9781910701881',
                'status' => 'Tersedia',
                'category_id' => 4,
                'image' => 'covers/homo_deus.jpg',
                'description' => 'Masa depan umat manusia dan tantangan teknologi.'
            ],
            [
                'title' => 'Madilog',
                'author' => 'Tan Malaka',
                'isbn' => '9789791684040',
                'status' => 'Tersedia',
                'category_id' => 4,
                'image' => 'covers/madilog.jpg',
                'description' => 'Pemikiran legendaris tentang Materialisme, Dialektika, dan Logika.'
            ],
        ];

        // Gabungkan dan simpan ke database
        $allBooks = array_merge($popularBooks, $categoryBooks);

        foreach ($allBooks as $book) {
            // Menggunakan updateOrCreate untuk mencegah error duplikasi jika dijalankan ulang
            Book::updateOrCreate(
                ['isbn' => $book['isbn']], // Kunci pengecekan unik berdasarkan ISBN
                $book
            );
        }
    }
}