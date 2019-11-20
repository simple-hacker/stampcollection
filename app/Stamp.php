<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $guarded = [];

    // protected $hidden = ['image_url'];

    protected $with = ['issue'];

    /**
     * Issue
     */
    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

    /**
     * Users
     *
     */
    public function users()
    {
        return $this->belongsToMany('App\Stamp', 'collections')->withTimestamps();
    }

    /**
     * Generate the whole url for displaying an image for a given stamp
     */
    public function getImageSrcAttribute()
    {
        return ($this->image) ? 'storage/stamps/' . $this->image : 'storage/stamps/no_image.jpg';
    }

    /**
     * Returns a slug of the stamp's title.
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }


    /**
     * Returns the url path to view the stamp.
     */
    public function addToCollectionPath()
    {
        return route('collection.add', ['stamp' => $this]);
    }

    /**
     * Returns the url path to view the stamp.
     */
    public function deleteFromCollectionPath()
    {
        return route('collection.delete', ['stamp' => $this]);
    }
}
