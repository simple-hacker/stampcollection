<?php

namespace App\Jobs;

use App\Stamp;
use App\Denomination;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateDenominationValues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $denomination = Denomination::all();

        $denomination->each(function($denomination) {
            Stamp::where('denomination', '=', $denomination->denomination)->update(['face_value' => $denomination->value]);
        });
    }
}
