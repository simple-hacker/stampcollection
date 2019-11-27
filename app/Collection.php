<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * Returns the stamp of the collection row's stamp_id
     *  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stamp()
    {
        return $this->belongsTo('App\Stamp');
    }

    /**
     * Returns the grading of the collection row's grading_id
     *  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grading()
    {
        return $this->belongsTo('App\Grading');
    }

    /**
     * Returns the issue of the collection row through the stamp_id
     *  
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function issue()
    {
        return $this->hasOneThrough('App\Issue', 'App\Stamp');
    }

    
}
