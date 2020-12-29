<?php

namespace App\Jobs;

use App\Stamp;
use App\StampClass;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStampClassValues implements ShouldQueue
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
        $classes = StampClass::all();

        $classes->each(function($class) {
            Stamp::where('class', '=', $class->class)->update(['face_value' => $class->value]);
        });
    }
}
