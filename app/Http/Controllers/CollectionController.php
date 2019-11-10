<?php

namespace App\Http\Controllers;

use App\User;
use App\Issue;
use App\Stamp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Description
     *
     * @param string name
     *
     * @return void
     */
    public function show()
    {
        // $collection = auth()->user()->stamps->groupBy('issue.id');

        $collection = Issue::whereHas('stamps')
                        ->with([
                            'stamps' => function ($query) {
                                $query->whereIn('id', DB::table('collections')
                                    ->select(DB::raw('stamp_id'))
                                    ->where('user_id', '=', auth()->user()->id)
                                    ->get());
                            }
                        ])
                        ->get();

        return view('collection.index', compact('collection'));
    }

    /**
     * Adds a stamp to the auth user's collection.
     *
     * @param Stamp $stamp
     *
     * @return null
     */
    public function store(Stamp $stamp)
    {
        auth()->user()->stamps()->attach($stamp);

        return redirect(route('browse.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));
    }

    /**
     * Removes a stamp from the auth user's collection.
     *
     * @param Stamp $stamp
     *
     * @return null
     */
    public function destroy(Stamp $stamp)
    {
        auth()->user()->stamps()->detach($stamp);

        return redirect(route('browse.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));
    }
}
