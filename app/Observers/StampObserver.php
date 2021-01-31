<?php

namespace App\Observers;

use App\Stamp;

class StampObserver
{
    /**
     * Handle the stamp "saving" event.
     *
     * @param  \App\Stamp  $stamp
     * @return void
     */
    public function saving(Stamp $stamp)
    {
        // Remove sg from sg_number if the user provided as this is aadded on with an attribute accessor in Stamp.php
        $stamp->sg_number = preg_replace("/^sg/i", "", $stamp->sg_number);
    }
}
