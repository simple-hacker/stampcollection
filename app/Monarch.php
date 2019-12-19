<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monarch extends Model
{
    protected $guarded = [];

    // This is the correct spelling rather than Larave's monarches
    protected $table = 'monarchs';
}
