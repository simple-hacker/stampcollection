<?php

namespace App\Http\Controllers;

use App\Year;
use App\Issue;
use App\Stamp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
     *
     * @return \Illuminate\View\View
     */
    public function create(Issue $issue)
    {
        $stamp = new Stamp;

        return view('stamp.create', compact('issue', 'stamp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Issue $issue)
    {
        $attributes = $this->validateRequest($request);

        // This sends the file to be uploaded, and returns the string to the file path to be saved in the stamp model.
        if ($request->has('image')) {
            $attributes['image'] = $this->upload_image($attributes['image'], $issue, null, $attributes['title']);
        }

        $issue->stamps()->create($attributes);

        return redirect(route('catalogue.issue', [
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
     *
     * @return \Illuminate\View\View
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Stamp $stamp)
    {
        $attributes = $this->validateRequest($request);

        // This sends the file to be uploaded, and returns the string to the file path to be saved in the stamp model.
        if ($request->has('image')) {
            $attributes['image'] = $this->upload_image($attributes['image'], $stamp->issue, $stamp, $attributes['title']);
        }

        $stamp->update($attributes);

        return redirect(route('catalogue.issue', [
                    'issue' => $stamp->issue,
                    'slug' => $stamp->issue->slug
                ]))
                ->withToastSuccess('Updated ' . $stamp->fresh()->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stamp  $stamp
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Stamp $stamp)
    {
        // Delete the image if it exists.
        if ($stamp->image) {
            if (Storage::disk('public')->exists('stamps/' . $stamp->image)) {
                Storage::disk('public')->delete('stamps/' . $stamp->image);
            }
        }

        $stamp->delete();

        return redirect(route('catalogue.issue', [
                    'issue' => $stamp->issue,
                    'slug' => $stamp->issue->slug,
                ]))
                ->withToastWarning("Successfully deleted {$stamp->title}");
    }

    /**
     * Save the uploaded image to storage and return a string of the path.
     *
     * @param UploadedFile $image
     * @param \App\Issue $issue
     * @param \App\Stamp $stamp
     * @param string $title
     *
     * @return string
     */
    public function upload_image($image, $issue, $stamp = null, $title)
    {
        // If $stamp != null then
        // if file $stamp->image exists then delete
        if ($stamp) {
            if ($stamp->image) {
                if (Storage::disk('public')->exists('stamps/' . $stamp->image)) {
                    Storage::disk('public')->delete('stamps/' . $stamp->image);
                }
            }
        }

        $folder = substr(md5($issue->id . $issue->title), -5) . "_" . Str::slug($issue->title);
        $filename = substr(md5($image->getClientOriginalName()), -5) . "_" . Str::slug($title) . "." . $image->getClientOriginalExtension();
        $path = "{$folder}/{$filename}";

        // Save the image.
        $image->storeAs('stamps/' . $folder, $filename, 'public');
        return $path;
    }

    /**
    * Validate the request for store and update.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function validateRequest($request)
    {
        return $request->validate([
            'title' => 'required|min:3|max:255',
            'sg_number' => 'nullable|alpha_num|min:1',
            'sg_illustration' => 'nullable|string|min:1',
            'denomination' => 'nullable|string|min:1',
            'description' => 'nullable|min:1',
            'face_value' => 'nullable|numeric|min:0',
            'mint_value' => 'nullable|numeric|min:0',
            'used_value' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);
    }

    /**
     * Show list of stamps for mass editing.
     *
     * @return \Illuminate\View\View
     */
    public function showMultiple($year = null)
    {
        $catalogue = Issue::orderBy('release_date', 'desc')
                            ->with('stamps')
                            ->get()
                            ->keyBy('id')
                            ->groupBy('year', true)
                            ->sortByDesc('year');

        $years = Year::orderBy('year', 'desc')->pluck('year');

        if (!isset($year)) {
            // If not year in URL, then get the latest year we have entered.
            $year = $years[0];
        } else {
            // If year is in URL, check if it's a valid year by seeing if it's in the array of years.
            // dd($years);
            if (!in_array($year, $years->toArray())) {
                abort(404);
            }
        }

        return view('admin.stamps', compact('catalogue', 'years', 'year'));
    }

    /**
     * Show list of stamps for mass editing.
     *
     * @return \Illuminate\View\View
     */
    public function updateMultiple(Request $request)
    {
        $messages = [
            '*.id.required' => 'Stamps should have an id.',
            '*.id.exists' => 'This stamp does not exist.',
            '*.denomination.required' => 'Denomination is required.',
            '*.title.required' => 'Title is required.',
            '*.title.min' => 'Min title length is 3 characters.',
            '*.title.max' => 'Max title length is 255 characters.',
            '*.sg_number.max' => 'Stanley Gibbons number only allows alphanumeric characters.',
            '*.face_value.numeric' => 'Numeric values only.',
            '*.mint_value.numeric' => 'Numeric values only.',
            '*.used_value.numeric' => 'Numeric values only.',
        ];

        $validator = Validator::make($request->all(), [
            '*.id' => 'required|exists:stamps,id',
            '*.denomination' => 'nullable|string',
            '*.title' => 'required|min:3|max:255',
            '*.description' => 'nullable|string',
            '*.sg_number' => 'nullable|alpha_num|min:1',
            '*.sg_illustration' => 'nullable|string|min:1',
            '*.face_value' => 'nullable|numeric|min:0',
            '*.mint_value' => 'nullable|numeric|min:0',
            '*.used_value' => 'nullable|numeric|min:0',
        ], $messages);

        if ($validator->validate()) {
            foreach ($request->all() as $stamp) {
                Stamp::findOrFail($stamp['id'])
                        ->update([
                            'denomination' => $stamp['denomination'],
                            'title' => $stamp['title'],
                            'description' => $stamp['description'],
                            'sg_number' => $stamp['sg_number'],
                            'sg_illustration' => $stamp['sg_illustration'],
                            'face_value' => $stamp['face_value'],
                            'mint_value' => $stamp['mint_value'],
                            'used_value' => $stamp['used_value'],
                        ]);
            }

            return response('Success', 200);
        }

        return response('Error', 400);
    }
}
