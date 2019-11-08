<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cgbs_issue' => 'integer',
        'year' => 'integer',
        'release_date' => 'date',
    ];

    /**
     * An issue has many stamps;
     * 
     * @return void
     */
    public function stamps()
    {
        return $this->hasMany('App\Stamp');
    }

    /**
     * Returns a slug of the title
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }

    /**
     * Returns the path url for the issue.
     *  
     * @return string
     */
    public function path()
    {
        return $this->id . '/' . $this->slug;
    }
}
