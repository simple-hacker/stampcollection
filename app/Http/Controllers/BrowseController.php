<?php

namespace App\Http\Controllers;

use App\Issue;

class BrowseController extends Controller
{
    /**
     * Index view shows all the issues for the given year.
     */
    public function index($year)
    {
        if (! \DB::table('years')->where('year', $year)->exists()) {
            abort(404);
        }

        $issues = Issue::where('year', $year)->with('stamps')->get();

        return view('browse.index', compact('year', 'issues'));
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
        
        return view('browse.issue', compact('issue'));
    }
}
