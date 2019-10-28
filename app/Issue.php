<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = [];

    /**
     * Description
     *  
     * @param string name
     * 
     * @return void
     */
    public function stamps()
    {
        return $this->hasMany('App\Stamp');
    }
}
