<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->string('isbn')->unique();
        
        // --- TAMBAHKAN KOLOM INI ---
        $table->integer('stock')->default(0); // Untuk jumlah stok buku
        $table->string('image')->nullable(); // Untuk simpan nama file gambar
        $table->text('description')->nullable(); // Untuk isi sinopsis buku
        $table->integer('pages')->default(0); // Untuk jumlah halaman
        $table->string('language')->default('Indonesia'); // Untuk bahasa
        $table->integer('published_year')->nullable(); // Untuk tahun terbit
        // ---------------------------

        $table->enum('status', ['Tersedia','Dipinjam'])->default('Tersedia');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
