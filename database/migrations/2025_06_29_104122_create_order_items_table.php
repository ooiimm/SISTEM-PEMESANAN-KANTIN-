<?php

// database/migrations/xxxx_create_order_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('harga_satuan'); // Simpan harga saat itu, untuk jaga-jaga jika harga menu berubah
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
