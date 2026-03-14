<?php

/**
 * @author Maxime Pol Marcet
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cinema practice – Actor model (NFR2).
 * I represent an actor in the cinema database. I use the actors table and maintain
 * the many-to-many relationship with Film through the films_actors pivot table.
 */
class Actor extends Model
{
    use HasFactory;

    /**
     * Attributes that I allow for mass assignment when creating or updating an actor.
     */
    protected $fillable = [
        'name',
        'surname',
        'birthdate',
        'country',
        'img_url',
    ];

    /**
     * I cast birthdate as a date (YYYY-MM-DD format).
     */
    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * I return the relationship with the films this actor has participated in (many-to-many via films_actors).
     */
    public function films()
    {
        return $this->belongsToMany(Film::class, 'films_actors');
    }
}
