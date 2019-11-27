<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cgbs_issue' => 'integer',
        'year' => 'integer',
        'release_date' => 'date:Y-m-d',
    ];

    /**
     * An issue has many stamps;
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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

    /**
     * Always convert the date to Y-m-d
     * 
     * @param string $date
     * @return mixed
     */
    public function getReleaseDateAttribute($date)
    {
        if ($date !== null) {
            return ($date !== '0000-00-00') ? (new Carbon($date))->format('Y-m-d') : null;
        }
    }
}
