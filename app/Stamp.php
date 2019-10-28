<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $guarded = [];

    /**
     * Description
     *  
     * @param string name
     * 
     * @return void
     */
    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }
}
