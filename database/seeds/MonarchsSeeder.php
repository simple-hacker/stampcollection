<?php

use Illuminate\Database\Seeder;

class MonarchsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monarchs = [
            [
                'abbreviation' => 'QV',
                'monarch' => 'Queen Victoria',
            ],
            [
                'abbreviation' => 'KEVII',
                'monarch' => 'King Edward VII',
            ],
            [
                'abbreviation' => 'KGV',
                'monarch' => 'King George V',
            ],
            [
                'abbreviation' => 'KEVIII',
                'monarch' => 'King Edward VIII',
            ],
            [
                'abbreviation' => 'KGVI',
                'monarch' => 'King George VI',
            ],
            [
                'abbreviation' => 'QEII',
                'monarch' => 'Queen Elizabeth II',
            ],
        ];

        DB::table('monarchs')->insert($monarchs);
    }
}
