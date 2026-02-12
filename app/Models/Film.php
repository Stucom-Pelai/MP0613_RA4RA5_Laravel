<?php

/**
 * @author Maxime Pol Marcet
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cinema practice – Film model (NFR1).
 * I represent a film in the cinema database. I use the films table and maintain
 * the many-to-many relationship with Actor through the films_actors pivot table.
 */
class Film extends Model
{
    use HasFactory;

    /**
     * Attributes that I allow for mass assignment when creating or updating a film.
     */
    protected $fillable = [
        'name',
        'year',
        'genre',
        'img_url',
        'country',
        'duration',
    ];

    /**
     * I return the relationship with the actors that participate in this film (many-to-many via films_actors).
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'films_actors');
    }
}
