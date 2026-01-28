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
        Schema::create('favorite_films', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('tmdb_id');
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->date('release_date')->nullable();
            $table->float('vote_average')->default(0);
            $table->unsignedInteger('vote_count')->default(0);
            $table->float('popularity')->default(0);
            $table->json('genre_ids')->nullable();
            $table->text('personal_note')->nullable();
            $table->enum('watch_status', ['want_to_watch', 'watching', 'watched'])->default('want_to_watch');
            $table->tinyInteger('rating')->nullable();
            $table->timestamps();

            // Ensure user can't add same film twice
            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_films');
    }
};
