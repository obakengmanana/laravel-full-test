<?php

namespace App\Console\Commands;

use App\Models\Credit;
use App\Models\Movie;
use App\Services\TheMovieDatabaseService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetTopMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brave:get-movies {max=500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a set of the most well rated movies to populate the database with from TMDB';

    /**
     * This command uses the TMDB API Service to fetch a bunch of top-rated movies and populate the database with the
     * results.
     *
     * @return int
     */
    public function handle()
    {
        $tmdb = new TheMovieDatabaseService();
        $movies = [];
        $paged = 1;
        $total_pages = 2;
        $max = $this->argument('max');
        $count = 0;

        while ($count < $max && $paged < $total_pages) {
            $tmbd_movies = $tmdb->get_top_rated_movies($paged);

            if (!$tmbd_movies) {
                $this->error("The request to the TMDB API failed at page $paged. Check the log for more details.");
                return Command::FAILURE;
            }

            $total_pages = $tmbd_movies['total_pages'] ?? 1;
            $movies = array_merge($movies, $tmbd_movies['results']);
            $paged++ ;
            $count = count($movies);
            $this->line("Fetched $count movies of $max." );

            if ($count > $max) {
                $movies = array_slice($movies, 0, $max);
                $count = $max;
            }
        }

        $this->line("Adding or Updating found movies to the database.");

        foreach ($movies as $movie) {
            $this->info("Synchronising movie: [" . $movie['title'] . "]");

            $new_movie = Movie::updateOrCreate( [
                "tmdb_id"       => $movie['id'],
            ], [
                "title"         => $movie['title'],
                "description"   => $movie['overview'],
                "poster_image"  => $movie['poster_path'],
                "rating"        => $movie['vote_average'],
                "release_date"  => Carbon::parse($movie['release_date']),
            ]);

            $credits = $tmdb->get_credits_for_movie($movie['id']);

            if ($credits && is_array($credits)) {
                if (isset($credits['crew']) && is_array($credits['crew'])) {
                    $tmdb_directors = array_filter($credits['crew'], function($crew_member) {
                        return isset($crew_member['job']) && $crew_member['job'] == 'Director';
                    });

                    if (is_array($tmdb_directors)) {
                        $tmdb_director = array_pop($tmdb_directors);

                        $this->line("Found director: " . $tmdb_director['name']);
                        $director = Credit::updateOrCreate([
                                'tmdb_id'   => $tmdb_director['id']
                            ], [
                                'name'      => $tmdb_director['name'],
                                'know_for'  => $tmdb_director['known_for_department'],
                                'tmdb_id'   => $tmdb_director['id']
                        ]);
                        $new_movie->director()->associate($director);
                    }
                }

                if (isset($credits['cast']) && is_array($credits['cast'])) {
                    usort($credits['cast'], function($a, $b) {
                        return $b['popularity'] - $a['popularity'];
                    });

                    $top_cast = array_slice(
                        $credits['cast'],
                        0,
                        10
                    );

                    foreach ($top_cast as $cast_member) {
                        $credit = Credit::updateOrCreate([
                            'tmdb_id'   => $cast_member['id']
                        ], [
                            'name'      => $cast_member['name'],
                            'know_for'  => $cast_member['known_for_department'],
                            'tmdb_id'   => $cast_member['id']
                        ]);
                        $credit->save();
                        $credit->credited_in()->attach([$new_movie->id]);
                        $credit->save();
                    }

                    $this->line("Added cast members: " . implode(', ', array_column($top_cast, 'name')));
                }
            } else {
                $this->warn("Could not set Director & Cast");
            }


            $new_movie->save();
            $this->newLine(2);

        }

        return Command::SUCCESS;
    }
}
