<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
    'isbn', 
    'title', 
    'author', 
    'category_id', 
    'image',        // Pastikan ini ada
    'description',  // Pastikan ini ada
    'stock', 
    'status'
];

   // app/Models/Book.php

    public function category()
    {
        // Mengasumsikan setiap buku memiliki satu kategori
        return $this->belongsTo(Category::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}

