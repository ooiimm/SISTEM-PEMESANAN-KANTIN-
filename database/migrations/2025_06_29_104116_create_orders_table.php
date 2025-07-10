<?php

// database/migrations/xxxx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang pesan
            $table->integer('nomor_meja');
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'selesai'])->default('pending'); // Status pesanan
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};