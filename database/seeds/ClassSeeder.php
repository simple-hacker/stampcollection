<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            [
                'class' => '1st',
                'value' => 0.76,
            ],
            [
                'class' => '2nd',
                'value' => 0.65,
            ],
            [
                'class' => '1st Large',
                'value' => 1.15,
            ],
            [
                'class' => '2nd Large',
                'value' => 0.88,
            ],
        ];

        DB::table('classes')->insert($classes);
    }
}
