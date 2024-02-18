<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class defining a credit on the movie, like directors or cast members.
 *
 * @mixin Builder
 */
class Credit extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'know_for',
        'tmdb_id'
    ];

    /**
     * Define the director relationship
     *
     * @return HasMany Can be director of multiple movies if they are a director.
     */
    function directed() {
        return $this->hasMany(Movie::class , 'credit_movie');
    }

    /**
     * Define the relationship to movies where this credit appears
     *
     * @return BelongsToMany Can be a crew member of multiple movies.
     */
    function credited_in() {
        return $this->belongsToMany(Movie::class, 'credit_movie', 'credit_id',  'movie_id' );
    }
}
