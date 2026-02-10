<?php

/**
 * @author Maxime Pol Marcet
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cinema practice – NFR2: create_actors_table migration.
 * I create the actors table in the cinema database with birthdate in YYYY-MM-DD format.
 */
return new class extends Migration {
    /**
     * I run the migration: I create the actors table with id (auto-increment primary key),
     * name (30), surname (30), birthdate (date), country (30), img_url (255) and timestamps.
     */
    public function up(): void
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('surname', 30);
            $table->date('birthdate');
            $table->string('country', 30);
            $table->string('img_url', 255);
            $table->timestamps();
        });
    }

    /**
     * I reverse the migration: I drop the actors table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('actors');
    }
};
