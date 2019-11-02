<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cgbs_issue' => 'integer',
        'year' => 'integer',
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
}
