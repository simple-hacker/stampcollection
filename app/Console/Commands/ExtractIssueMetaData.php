<?php

namespace App\Console\Commands;

use App\Issue;
use Illuminate\Console\Command;

class ExtractIssueMetaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issues:metadata {issue?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract issue metadata from description';

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
        $issueId = $this->argument('issue');

        $issues = ($issueId) ? Issue::findOrFail($issueId) : Issue::all();

        $count = ($issues instanceof Issue) ? 1 : $issues->count();

        if ($count === 1) {
            $this->extractMetaData($issues);
        } else {

            $bar = $this->output->createProgressBar($count);

            $bar->start();

            $issues->each(function ($issue) use ($bar) {
                $this->extractMetaData($issue);
                $bar->advance();
            });

            $this->info('');
            $bar->finish();
        }
    }

    private function extractMetaData(&$issue)
    {
        $category = "/(Commemorative|Definitive|Post & Go)[\n|\r]?/i";
        $designer = "/\bDesigned by\b (.+)[\n|\r]?/i";
        $size = "/\bSize\b (.+)[\n|\r]?/i";
        $printer = "/\bPrinted By\b (.+)[\n|\r]?/i";
        $print_process = "/\bPrint Process\b (.+)[\n|\r]?/i";
        $perforations = "/\bPerforations\b (.+)[\n|\r]?/i";
        $gum = "/\bGum\b (.+)[\n|\r]?/i";

        dump($issue->getAttributes());

        // TODO: Category

        preg_match($designer, $issue->description, $designerMatches);
        if ($designerMatches) {
            $issue->designer = trim($designerMatches[1]);
            $issue->description = str_replace($designerMatches[0], '', $issue->description);
        }

        preg_match($size, $issue->description, $sizeMatches);
        if ($sizeMatches) {
            $issue->size = trim($sizeMatches[1]);
            $issue->description = str_replace($sizeMatches[0], '', $issue->description);
        }

        preg_match($printer, $issue->description, $printerMatches);
        if ($printerMatches) {
            $issue->printer = trim($printerMatches[1]);
            $issue->description = str_replace($printerMatches[0], '', $issue->description);
        }

        preg_match($print_process, $issue->description, $print_processMatches);
        if ($print_processMatches) {
            $issue->print_process = trim($print_processMatches[1]);
            $issue->description = str_replace($print_processMatches[0], '', $issue->description);
        }

        preg_match($perforations, $issue->description, $perforationsMatches);
        if ($perforationsMatches) {
            $issue->perforation = trim($perforationsMatches[1]);
            $issue->description = str_replace($perforationsMatches[0], '', $issue->description);
        }

        preg_match($gum, $issue->description, $gumMatches);
        if ($gumMatches) {
            $issue->gum = trim($gumMatches[1]);
            $issue->description = str_replace($gumMatches[0], '', $issue->description);
        }

        // Final trim
        $issue->description = trim($issue->description);

        dump($issue->getAttributes());
    }
}
