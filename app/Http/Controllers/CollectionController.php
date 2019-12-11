<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use App\Grading;
use App\Collection;
use Illuminate\Http\Request;
use Validator;

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
    public function store(Request $request)
    {
        $messages = [
            '*.grading_id.required' => 'Please select a grading type.',
            '*.grading_id.exists' => 'You have not selected a valid grading type.',
            '*.value.required' => 'Please enter a value.',
            '*.value.numeric' => 'Please enter a valid value, max two decimal places.',
            '*.value.regex' => 'Please enter a valid value, max two decimal places.'
        ];

        $validator = Validator::make($request->stampsToAdd, [
            '*.grading_id' => 'required|integer|exists:gradings,id',
            '*.value' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ], $messages);

        
        if ($attributes = $validator->validate()) {

            foreach($request->stampsToAdd as $attributes) {
                auth()->user()->stamps()->attach($request->stamp['id'], $attributes);
            }

            // Got an extra DB call here.  Ideally after adding we return the data that was posted and push to the collection
            // array in the modal instead of overwriting it completely with the DB call data.
            // Haven't done it yet because the data keys aren't matching.
            // This return returns id, user_id, stamp_id, grading_id, value etc WITH gradings and stamp data.
            // Posted data was only grading_id and value.  Missing grading_type to display.
            
            return auth()->user()->collection()->where('stamp_id', $request->stamp['id'])->get();
        }

        return "Error?";
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

        if ($collection->delete()) {
            return "Success";
        }

        return abort(401);
        
        // return redirect(route('catalogue.issue', ['issue' => $collection->stamp->issue, 'slug' => $collection->stamp->issue->slug]))
        //         ->withToastWarning('Removed ' . $collection->stamp->title . ' from your collection.');
    }
}
