<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'year';

    public $incremeting = false;

    public $timestamps = false;
}
