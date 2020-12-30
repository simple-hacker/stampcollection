<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $denominations = [
            [
                'denomination' => '1st',
                'value' => 0.76,
            ],
            [
                'denomination' => '2nd',
                'value' => 0.65,
            ],
            [
                'denomination' => '1st Large',
                'value' => 1.15,
            ],
            [
                'denomination' => '2nd Large',
                'value' => 0.88,
            ],
        ];

        DB::table('denominations')->insert($denominations);
    }
}
