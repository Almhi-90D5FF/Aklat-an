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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            // who made the reservation
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // which section is being reserved
            $table->foreignId('section_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // booking details
            $table->date('date');
            $table->string('time_slot'); // e.g. 8-11, 11-2, 2-5
            $table->string('purpose')->nullable();
            $table->string('status')->default('confirmed');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
