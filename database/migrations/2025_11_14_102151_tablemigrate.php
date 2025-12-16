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
            $table->string('title', 255);
            $table->string('author', 100);
            $table->integer('ISBN');
            $table->enum('status', ['available', 'reserved']);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        });


        Schema::create('penalties', function (Blueprint $table) {
            $table->id(); 
            $table->integer('user_id');
            $table->integer('reservation_id');
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['paid', 'unpaid']);
            $table->datetime('issued_at');
            $table->foreignId('reservations_id');
            $table->foreignId('reservations_users_id');
            $table->foreignId('reservations_books_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('books');
        Schema::dropIfExists('penalties');
    }
};
