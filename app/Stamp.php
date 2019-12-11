<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sg_number' => 'integer',
    ];

    protected $with = ['issue'];

    protected $appends = ['image_src', 'prefixedSgNumber'];

    /**
     * Issue
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

    /**
     * Users
     *
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Stamp', 'collections')->withTimestamps();
    }

    /**
     * Generate the whole url for displaying an image for a given stamp
     * 
     * @return string
     */
    public function getImageSrcAttribute()
    {
        return ($this->image) ? 'storage/stamps/' . $this->image : 'storage/stamps/no_image.jpg';
    }

    /**
     * Returns a slug of the stamp's title.
     * 
     * @return string
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }


    /**
     * Returns the url path to view the stamp.
     * 
     * @return \Illuminate\Routing\Redirector
     */
    public function addToCollectionPath()
    {
        return route('collection.add', ['stamp' => $this]);
    }

    /**
     * Returns the url path to view the stamp.
     * 
     * @return \Illuminate\Routing\Redirector
     */
    public function deleteFromCollectionPath()
    {
        return route('collection.delete', ['stamp' => $this]);
    }

    /**
     * Prefixed SG to the Stanley Gibbons number.
     * 
     * @return string|null
     */
    public function getPrefixedSgNumberAttribute() {
        if ($this->sg_number) {
            return 'SG' . $this->sg_number;
        }

        return null;
    }
}
