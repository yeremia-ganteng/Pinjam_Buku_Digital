<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $blogs = [
            [
                'title' => 'Tips Membaca Efektif',
                'content' => "Membaca efektif bukan berarti cepat, melainkan memahami isi bacaan dengan baik. Gunakan teknik SQ3R (Survey, Question, Read, Recite, Review) untuk meningkatkan pemahaman."
            ],
            [
                'title' => 'Kenapa Membaca Sains Itu Penting',
                'content' => "Membaca buku sains membuka wawasan tentang dunia dan teknologi. Dengan memahami sains, kita bisa lebih kritis terhadap informasi dan siap menghadapi perkembangan zaman."
            ],
            [
                'title' => 'Manfaat Membaca Fiksi',
                'content' => "Fiksi membantu kita berempati dengan karakter, memperluas imajinasi, dan mengurangi stres. Membaca novel bisa menjadi cara relaksasi sekaligus melatih kreativitas."
            ],
            [
                'title' => 'Sejarah Membentuk Identitas Bangsa',
                'content' => "Buku sejarah memberi kita pemahaman tentang perjalanan bangsa. Dengan membaca sejarah, kita bisa belajar dari masa lalu dan membangun masa depan yang lebih baik."
            ],
            [
                'title' => 'Membaca Bisnis untuk Masa Depan',
                'content' => "Literatur bisnis mengajarkan strategi, kepemimpinan, dan inovasi. Dengan membaca buku bisnis, kita bisa menyiapkan diri menghadapi tantangan dunia kerja modern."
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}

