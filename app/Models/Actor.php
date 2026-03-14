<?php

/**
 * Actor model (Eloquent ORM).
 *
 * This file was introduced so that the application no longer relies on JSON-based
 * data handling. The Actor entity is represented as an Eloquent model mapping to
 * the actors table, ensuring a consistent and maintainable data layer for all
 * future features (NFR2, Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Actor model is used to represent a single row in the actors table.
 * Eloquent conventions are followed: the table name is inferred as the plural
 * form of the class name (actors), matching the migration-backed table.
 */
class Actor extends Model
{
    use HasFactory;

    /**
     * These attributes are marked as fillable so that mass assignment is allowed
     * when creating or updating records via Eloquent or factories, while keeping
     * the model secure against arbitrary input.
     */
    protected $fillable = [
        'name',
        'surname',
        'birthdate',
        'country',
        'img_url',
    ];

    /**
     * The birthdate attribute is cast to a date so that it is always returned
     * as a Carbon instance and stored in YYYY-MM-DD format, matching the
     * database column type and avoiding manual parsing in the application.
     */
    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * The many-to-many relationship with Film is defined via the films_actors
     * pivot table. withTimestamps() is used because the pivot table has
     * created_at and updated_at columns that must be maintained by Eloquent.
     */
    public function films()
    {
        return $this->belongsToMany(Film::class, 'films_actors')
            ->withTimestamps();
    }
}
