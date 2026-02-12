<?php

/**
 * @author Maxime Pol Marcet
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cinema practice – NFR1: create_films_table migration.
 * I create the films table in the cinema database with the format specified in the technical design.
 */
return new class extends Migration {
    /**
     * I run the migration: I create the films table with id (auto-increment primary key),
     * name (100), year, genre (50), country (30), duration, img_url (255) and timestamps.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('year');
            $table->string('genre', 50);
            $table->string('country', 30);
            $table->integer('duration');
            $table->string('img_url', 255);
            $table->timestamps();
        });
    }

    /**
     * I reverse the migration: I drop the films table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
