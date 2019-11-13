<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use Illuminate\Http\Request;

class StampController extends Controller
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
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function create(Issue $issue)
    {
        return view('stamp.create', compact('issue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Issue $issue)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|min:3',
            'price' => 'nullable|numeric',
        ]);

        $issue->stamps()->create($attributes);

        return redirect(route('browse.issue', [
            'issue' => $issue,
            'slug' => $issue->slug,
        ]))
        ->withToastSuccess('Added stamp ' . $attributes['title']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stamp  $stamp
     * @return \Illuminate\Http\Response
     */
    public function show(Stamp $stamp)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stamp  $stamp
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue, Stamp $stamp)
    {
        return view('stamp.edit', compact('stamp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stamp  $stamp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stamp $stamp)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|min:3',
            'price' => 'nullable|numeric|min:0'
        ]);

        $stamp->update($attributes);

        return redirect(route('browse.issue', [
            'issue' => $stamp->issue,
            'slug' => $stamp->issue->slug
        ]))
        ->withToastSuccess('Updated ' . $stamp->fresh()->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stamp  $stamp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stamp $stamp)
    {
        $issue = $stamp->issue;  //Grab the issue details before deleting the stamp so we can redirect to the issue.
        $title = $stamp->title;

        $stamp->delete();

        return redirect(route('browse.issue', [
                    'issue' => $issue,
                    'slug' => $issue->slug,
                ]))
                ->withToastWarning("Successfully deleted {$title}");
    }
}