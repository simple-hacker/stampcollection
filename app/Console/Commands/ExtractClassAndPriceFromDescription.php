<?php

namespace App\Console\Commands;

use App\Stamp;
use Illuminate\Console\Command;

class ExtractClassAndPriceFromDescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stamps:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract the class or price from the start of a stamps description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stamps = Stamp::all();
        // $stamps = Stamp::limit(50)->get();
        // $stamps = Stamp::whereIssueId(1079)->get();

        $bar = $this->output->createProgressBar(count($stamps));

        $bar->start();

        $stamps->each(function ($stamp) use ($bar) {
            $this->extractClassFromDescription($stamp);
            $bar->advance();
        });

        $this->info('');
        $bar->finish();
    }

    private function extractClassFromDescription($stamp)
    {
        $regex = "/^(£\d+\.\d{2,}|£\d+|\d+p|1st Large|2nd Large|1st|2nd|\d+s\d+d|\d+d|\d+½?d|\d*½d|\d+s\d+½?d|\d+s|\d+½?p)/i";
        preg_match($regex, trim($stamp->description), $class);

        if (isset($class[0])) {
            $stamp->class = $class[0];

            // Remove class or price from the start of the text including any left over whitespace
            if (substr($stamp->description, 0, strlen($class[0])) == $class[0]) {
                $stamp->description = trim(substr($stamp->description, strlen($class[0])));
            }

            $stamp->save();
        }
    }
}
