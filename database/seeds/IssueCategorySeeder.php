<?php

use Illuminate\Database\Seeder;

class IssueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('issue_categories')->insert([
            ['category' => 'Commemorative'],
            ['category' => 'Definitive']
        ]);
    }
}
