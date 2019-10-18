<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StampSet extends Model
{
    public $incrementing = false;

    protected $fillable = ['id', 'title', 'year', 'description', 'release_date'];
}
