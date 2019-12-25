<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Stamp extends Model implements Searchable
{
    protected $guarded = [];

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
        return ($this->image) ? '/storage/stamps/' . $this->image : 'storage/stamps/no_image.png';
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

    /**
    * Returns the search result for this model.
    *
    * @return \Spatie\Searchable\SearchResult
    */
    public function getSearchResult() : SearchResult
    {
        $url = route('catalogue.issue', ['issue' => $this->issue, 'slug' => $this->issue->slug]);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
