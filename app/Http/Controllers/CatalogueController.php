<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Year;

class CatalogueController extends Controller
{
    /**
     * Index view shows all the issues for the given year.
     * 
     * @param integer $year
     * 
     * @return Illuminate\View\View
     */
    public function index($year = null)
    {
        if (!isset($year)) {
            $year = date("Y");
        }

        // If the user changes the year in the URL to one that doesn't exist, abort.
        if (!\DB::table('years')->where('year', $year)->exists()) {
            abort(404);
        }

        $issues = Issue::where('year', $year)->orderBy('release_date', 'desc')->with('stamps')->get();
        $years = Year::all()->sortByDesc('year')->pluck('year');

        return view('catalogue.index', compact('year', 'years', 'issues'));
    }

    /**
     * Displays the given issue.
     *
     * @param \App\Issue $id
     * @param string $slug
     * 
     * @return Illuminate\View\View
     */
    public function issue(Issue $issue, $slug)
    {
        // If the slug does not match the provided issue id then abort.
        if ($issue->slug !== $slug) {
            abort(404);
        }

        // If a user is logged in then fetch the user's stamp collection.
        // Else just pass an empty array for guests.
        $collection = auth()->check() ? auth()->user()->stamps : [];

        return view('catalogue.issue', compact('issue', 'collection'));
    }
}
