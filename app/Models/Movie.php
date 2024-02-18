<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * This class defines the model of the Movie using Eloquent.
 * @mixin Builder
 */
class Movie extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "title",
        "description",
        "poster_image",
        "rating",
        "release_date",
        "tmdb_id",
        "director"
    ];

    protected $appends = [
        'year',
        'director_name'
    ];

    // ================== RELATIONSHIPS ======================

    /**
     * Define the relationship with the director.
     *
     * @return BelongsTo The director of the film.
     */
    public function director() {
        return $this->belongsTo(Credit::class, 'director_id');
    }

    /**
     * Define the relationship with the crew.
     *
     * @return BelongsToMany The director of the film.
     */
    public function cast() {
        return $this->belongsToMany(Credit::class, 'credit_movie',  'movie_id', 'credit_id');
    }



    // ================== ACCESSORS ======================

    /**
     * Accessor to prepend the URL of the image storage to the poster_image path.
     *
     * @return Attribute The URI for the poster image.
     */
    protected function posterImage(): Attribute {
        return Attribute::make(
            get: fn ($value) => env('TMDB_POSTER_BASE_URI') . $value
        );
    }

    /**
     * Accessor to only return the Year variable.
     *
     * @return Attribute The Year the movie was released.
     */
    protected function year(): Attribute {
        return Attribute::make(
            get: fn () => Carbon::make($this->release_date)->format('Y')
        );
    }


    /**
     * Accessor to prepend the URL of the image storage to the poster_image path.
     *
     * @return Attribute The URI for the poster image.
     */
    protected function directorName(): Attribute {
        return Attribute::make(
            get: fn () => $this->director()->get()[0]['name'] ?? false
        );
    }

}
