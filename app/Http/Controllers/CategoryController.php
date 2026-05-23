<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $books = Book::where('category_id', $category->id)->paginate(12);

        return view('kategori', compact('category', 'books'));
    }
}

