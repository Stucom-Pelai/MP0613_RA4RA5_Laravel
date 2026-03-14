<?php

/**
 * Film model (Eloquent ORM).
 *
 * This file was introduced so that the application no longer relies on JSON-based
 * data handling. The Film entity is represented as an Eloquent model mapping to the
 * films table, ensuring a consistent and maintainable data layer for all future
 * features (NFR1, Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Film model is used to represent a single row in the films table.
 * Eloquent conventions are followed: the table name is set explicitly so that
 * the model is bound to the correct migration-backed table.
 */
class Film extends Model
{
    use HasFactory;

    /**
     * The table name is set explicitly so that the model is bound to the films
     * table created by the migration, avoiding any convention mismatch.
     */
    protected $table = 'films';

    /**
     * These attributes are marked as fillable so that mass assignment is allowed
     * when creating or updating records via Eloquent (e.g. Film::create() or
     * Film::update()), while keeping the model secure against arbitrary input.
     */
    protected $fillable = [
        'name',
        'year',
        'genre',
        'country',
        'duration',
        'img_url',
    ];

    /**
     * The many-to-many relationship with Actor is defined via the films_actors
     * pivot table. withTimestamps() is used because the pivot table has
     * created_at and updated_at columns that must be maintained by Eloquent.
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'films_actors')
            ->withTimestamps();
    }
}
