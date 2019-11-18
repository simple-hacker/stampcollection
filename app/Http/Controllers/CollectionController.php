<?php

namespace App\Http\Controllers;

use App\User;
use App\Issue;
use App\Stamp;
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
        //
        $stampsInCollection = auth()->user()->stamps()->pluck('id')->toArray();

        $collection = Issue::whereHas('stamps', function ($query) use ($stampsInCollection) {
            $query->whereIn('id', $stampsInCollection);
        })
                        ->with([
                            'stamps' => function ($query) use ($stampsInCollection) {
                                $query->whereIn('id', $stampsInCollection);
                            }
                        ])
                        ->latest('release_date')
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

        return redirect(route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));
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

        return redirect(route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));
    }
}
