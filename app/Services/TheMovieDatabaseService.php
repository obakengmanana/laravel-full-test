<?php

    /**
     * This function provides the connection to The Movie Database
     * and handles the neccessary API Calls.
     *
     * This is based of the V3 API, documentation can be found here:
     * https://developers.themoviedb.org/3/getting-started
     */

    namespace App\Services;

    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Http\Client\Response;

    class TheMovieDatabaseService {

        protected string $base_url ='https://api.themoviedb.org/3';
        private string $api_key;

        /**
         * Constructor to set up the required URL and get the API key from the environment file.
         */
        public function __construct() {
            $this->api_key = env('TMDB_API_KEY_V3', '');
        }

        /**
         * Logs errors.
         *
         * @param Response $response The response of the failed request.
         */
        private function log_error($response)
        {
            Log::error("An API call failed.", [
                'Error Type:' => $response->serverError() ? 'Server Error' : ($response->clientError() ? 'Client Error' : 'Unknown Error'),
                'Error Body:' => $response->body() ?? '[EMPTY]'
            ]);
        }

        /**
         * Get the top-rated movies.
         *
         * API docs: https://developers.themoviedb.org/3/movies/get-top-rated-movies
         *
         * @param int $page The page to retrieve.
         * @return array|false Array of response data from the API, false if there were any request issues.
         */
        public function get_top_rated_movies( $page = 1 ) {

            $response = Http::get($this->base_url . '/movie/top_rated', [
                'api_key' => $this->api_key,
                'page' => $page
            ]);

            if ($response->failed()) {
                $this->log_error($response);
                return false;
            }
            return $response->json();
        }

        /**
         * Get the credits for a certain movie
         *
         * @param int $movie_id The id of the movie to fetch the cast and crew for.
         * @return array|false Array of response data from the API, false if there were any request issues.
         */
        public function get_credits_for_movie( $movie_id ) {
            if (!$movie_id) {
                return [];
            }

            $response = Http::get( "$this->base_url/movie/$movie_id/credits", [
                'api_key' => $this->api_key,
            ]);

            if ($response->failed()) {
                $this->log_error($response);
                return false;
            }
            return $response->json();
        }
    }
