<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Stamp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'sg_number' => 'nullable|alpha_num|min:1',
            'sg_illustration' => 'nullable|numeric|min:1',
            'description' => 'nullable|min:3',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

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
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'sg_number' => 'nullable|alpha_num|min:1',
            'sg_illustration' => 'nullable|numeric|min:1',
            'description' => 'nullable|min:3',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

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
}