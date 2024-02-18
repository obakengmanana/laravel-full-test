<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Movie::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('release_date', 'like', "%$query%")
            ->get();

        return response()->json($results);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');

        // Fetch autocomplete suggestions from your database based on the query
        $suggestions = Movie::select('movies.*', 'credits.name as director_name')
        ->leftJoin('credits', 'movies.director_id', '=', 'credits.id')
        ->where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->orWhere('release_date', 'like', "%$query%")
        ->orWhere('credits.name', 'like', "%$query%")
        ->get();

        

        return response()->json($suggestions);
    }
}
