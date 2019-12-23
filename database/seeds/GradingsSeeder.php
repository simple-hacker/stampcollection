<?php

use Illuminate\Database\Seeder;

class GradingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradings = [
            [
                'abbreviation' => 'MNH',
                'grading' => 'Mint Never Hinged',
                'type' => 'mint',
                'description' => 'Stamps as issued with full original gum and never mounted.'
            ],
            [
                'abbreviation' => 'VLMM',
                'grading' => 'Very Lightly Mounted Mint',
                'type' => 'mint',
                'description' => 'Stamps with a small trace of being hinged with near full original gum.'
            ],
            [
                'abbreviation' => 'LMM',
                'grading' => 'Lightly Mounted Mint',
                'type' => 'mint',
                'description' => 'As above but the stamps have slightly more evidence of being hinged.'
            ],
            [
                'abbreviation' => 'MM',
                'grading' => 'Mounted Mint',
                'type' => 'mint',
                'description' => 'Stamps which have been more heavily hinged with possible hinge remnants.'
            ],
            [
                'abbreviation' => 'VFU',
                'grading' => 'Very Fine Used',
                'type' => 'used',
                'description' => 'Used Stamps with a light cancel or Circular Date Stamp (CDS) or equivalent.'
            ],
            [
                'abbreviation' => 'FU',
                'grading' => 'Fine Used',
                'type' => 'used',
                'description' => 'These stamps are with slightly heavier or smudged cancel.'
            ],
            [
                'abbreviation' => 'GU',
                'grading' => 'Good Used',
                'type' => 'used',
                'description' => 'Nice collectable stamps with perhaps heavier cancel and minor faults, crease, short perfs etc.'
            ],
            [
                'abbreviation' => 'AU',
                'grading' => 'Average Used',
                'type' => 'used',
                'description' => 'Nice collectable stamps with perhaps heavier cancel and minor faults, crease, short perfs etc.'
            ]
        ];

        DB::table('gradings')->insert($gradings);
    }
}
