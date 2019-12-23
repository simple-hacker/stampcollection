<?php

use Illuminate\Database\Seeder;

class AddTypeToGradings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Do NOT at to DatabaseSeeder as GradingsSeeder has been updated.
        // Need to add types to gradings whilst in production as the table schema has changed.

        DB::update('UPDATE gradings SET `type`= "mint" WHERE abbreviation IN ("MNH", "VLMM", "LMM", "MM")');
        DB::update('UPDATE gradings SET `type` = "used" WHERE abbreviation IN ("VFU", "FU", "GU", "AU")');
    }
}
