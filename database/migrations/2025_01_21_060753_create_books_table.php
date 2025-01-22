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
        # NOTE: GPT-4o AND ALL THE OTHER MODELS SHOULD BE INCLUDED IN OUR GRADUATION CEREMONY, I OWE MY SANITY TO THEM ALL!!!!!!!1
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('book_name');
            $table->text('book_isbn');
            $table->text('book_desc');
            $table->foreignId('book_leaser')->nullable()->constrained('users'); // Assuming the leaser is a user
            $table->date('book_lease_end_date')->nullable();
            $table->text('book_cover');
            $table->foreignId('book_publisher')->constrained('users'); // Assuming the publisher is in a publishers table
            $table->timestamp('book_publish_date')->useCurrent(); // Corrected from timestamps() to timestamp
            $table->timestamps(); // Only once here
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
