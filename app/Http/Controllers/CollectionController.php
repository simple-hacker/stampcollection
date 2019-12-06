<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use App\Grading;
use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Load the user's Stamp Collection view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usersCollection = auth()->user()->collection;

        $stampsInCollection = $usersCollection->pluck('stamp_id')->unique()->toArray();

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

        $collectionData = $usersCollection->groupBy(['stamp_id', 'grading_id'])->toArray();
        $collectionValue = $usersCollection->sum('value');

        return view('collection.index', compact('collection', 'collectionData', 'collectionValue'));
    }

    /**
     * Shows details about the stamp, as well as what's in your collection.
     *  
     * @param \App\Stamp $stamp
     * @param string $slug
     * 
     * @return \Illuminate\View\View
     */
    public function show(Stamp $stamp)
    {
        $stampsInCollection = auth()->user()->collection()->where('stamp_id', $stamp->id)->get();
        $gradings = Grading::pluck('type', 'id');

        return [
            'stampsInCollection' => $stampsInCollection,
            'gradings' => $gradings,
        ];
    }

    /**
     * Adds a stamp to the auth user's collection.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Stamp $stamp
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Stamp $stamp)
    {
        // TODO: Need to validate grading_id is valid

        $attributes = $request->validate([
            'grading_id' => 'required|integer',
            'value' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'sometimes|integer|min:0'
        ]);

        $quantity = $attributes['quantity'];
        unset($attributes['quantity']);

        for ($i=1; $i <= $quantity; $i++) {
            auth()->user()->stamps()->attach($stamp, $attributes);
        }

        return redirect(route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]))
                ->withToastSuccess('Added ' . $stamp->title . ' to your collection.');;
    }

    /**
     * Removes a stamp from the auth user's collection.
     *
     * @param \App\Collection $collection
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Collection $collection)
    {
        if ($collection->user_id != auth()->user()->id) {
            abort(404);
        }

        $collection->delete();

        return redirect(route('catalogue.issue', ['issue' => $collection->stamp->issue, 'slug' => $collection->stamp->issue->slug]))
                ->withToastWarning('Removed ' . $collection->stamp->title . ' from your collection.');
    }
}
