<?php

namespace App\Http\Controllers;

use App\Year;
use App\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($year = null)
    {
        if (isset($year) && ($year > 1800) && ($year < 3000)) {
            $set_release_date = tap(Carbon::now())->setYear($year)->format('Y-m-d');
        } else {
            $set_release_date = Carbon::now()->toDateString();
        }

        $issue = new Issue;

        return view('issue.create', compact('year', 'set_release_date', 'issue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'cgbs_issue' => 'sometimes|nullable',
            'release_date' => 'required',
            'description' => 'nullable|min:3',
        ]); 
        
        $release_date = Carbon::parse($attributes['release_date']);
        
        $attributes['year'] = $release_date->year;

        // If an issue with the same title and release date exists then update, else create
        $issue = Issue::updateOrCreate([
            'title' => $attributes['title'],
            'release_date' => $attributes['release_date'],
        ], $attributes);

        // Add the year to list of years in case it doesn't exist.
        Year::firstOrCreate(['year' => $attributes['year']]);

        return redirect(route('browse.issue', ['issue' => $issue, 'slug' => $issue->slug]))
                ->withToastSuccess('Added issue ' . $issue->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        return view('issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'release_date' => 'required',
            'description' => 'nullable|min:3',
        ]);

        // Update the year depending on release_date
        $release_date = Carbon::parse($attributes['release_date']);
        $attributes['year'] = $release_date->year;

        $issue->update($attributes);

        return redirect(route('browse.issue', [
                    'issue' => $issue,
                    'slug' => $issue->slug,
                ]))
                ->withToastSuccess('Updated ' . $issue->fresh()->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $year = $issue->year;  //Grab the year before deleting so we can redirect to the correct year.
        $title = $issue->title;
        
        $issue->delete();

        return redirect(route('browse.year', compact('year')))
                ->withToastWarning("Successfully deleted {$title}");
    }
}
