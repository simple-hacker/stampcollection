<?php

namespace App;

use App\Scopes\GradingOrderByScope;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GradingOrderByScope);
    }
}
