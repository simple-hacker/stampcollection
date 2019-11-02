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

    /**
     * Description
     *  
     * @param string name
     * 
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'collections')->withTimestamps();
    }
}
