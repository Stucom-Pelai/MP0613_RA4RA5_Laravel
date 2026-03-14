<?php

/**
 * @author Maxime Pol Marcet
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cinema practice – NFR3: create_films_actors_table migration.
 * I create the films_actors pivot table linking each film to its actors via film_id and actor_id.
 */
return new class extends Migration {
    /**
     * I run the migration: I create the films_actors table with film_id and actor_id (unsignedBigInteger),
     * timestamps and foreign keys with on delete cascade to films and actors.
     */
    public function up(): void
    {
        Schema::create('films_actors', function (Blueprint $table) {
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('actor_id');
            $table->timestamps();

            $table->primary(['film_id', 'actor_id']);
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('actors')->onDelete('cascade');
        });
    }

    /**
     * I reverse the migration: I drop the films_actors table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('films_actors');
    }
};
