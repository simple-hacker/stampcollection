<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;

class SearchController extends Controller
{
    /**
    * This is a JSON POST request for searching.
    * Used for making an axios call in the Search Vue component.
    * 
    * @param string $query
    * @return \Illuminate\View\View
    */
    public function index($query)
    {
        $results = (new Search())
                    ->registerModel(Stamp::class, ['title'])
                    ->registerModel(Issue::class, ['title'])
                    ->search($query)
                    ->groupByType();

        if (request()->wantsJson()) {
            return response()->json($results);
        }

        return view('search.index', compact('results'));
    }
}
