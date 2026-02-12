<?php

/**
 * @author Maxime Pol Marcet
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cinema practice – RA6: create_producers_table migration.
 * I create the producers table in the cinema database with a one-to-one relationship to films.
 */
return new class extends Migration {
    /**
     * I run the migration: I create the producers table with id (auto-increment primary key),
     * film_id (unique foreign key to films), name (100), company (100, nullable), country (30) and timestamps.
     */
    public function up(): void
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id')->unique();
            $table->string('name', 100);
            $table->string('company', 100)->nullable();
            $table->string('country', 30);
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });
    }

    /**
     * I reverse the migration: I drop the producers table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('producers');
    }
};
