<?php

/**
 * @author Maxime Pol Marcet
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cinema practice – Producer model (RA6).
 * I represent a producer in the cinema database. I use the producers table and maintain
 * a one-to-one relationship with Film (each film has one producer).
 */
class Producer extends Model
{
    use HasFactory;

    /**
     * Attributes that I allow for mass assignment when creating or updating a producer.
     */
    protected $fillable = [
        'film_id',
        'name',
        'company',
        'country',
    ];

    /**
     * I return the relationship with the film this producer produces (one-to-one).
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
