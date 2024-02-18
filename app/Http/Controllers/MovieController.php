<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Retrieve a page of movies from the database, Default sorting is by Rating.
     *
     * @return View The basic view of movies for the current page.
     */
    public function page() {
        return view('index', [
            'movies' => Movie::orderBy('rating', 'desc')->paginate(8)
        ]);
    }
}
