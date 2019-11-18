<?php

namespace App\Http\Controllers;

use App\Issue;

class CatalogueController extends Controller
{
    /**
     * Index view shows all the issues for the given year.
     */
    public function index($year)
    {
        if (!\DB::table('years')->where('year', $year)->exists()) {
            abort(404);
        }

        $issues = Issue::where('year', $year)->orderBy('release_date', 'desc')->with('stamps')->get();

        return view('catalogue.index', compact('year', 'issues'));
    }

    /**
     * Displays the given issue.
     *
     * @param \App\Issue id
     * @param string slug
     */
    public function issue(Issue $issue, $slug)
    {
        if ($issue->slug !== $slug) {
            abort(404);
        }

        $collection = auth()->check() ? auth()->user()->stamps : [];

        return view('catalogue.issue', compact('issue', 'collection'));
    }
}
