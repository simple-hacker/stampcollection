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
                'type' => 'Mint Never Hinged',
                'description' => 'Stamps as issued with full original gum and never mounted.'
            ],
            [
                'abbreviation' => 'VLMM',
                'type' => 'Very Lightly Mounted Mint',
                'description' => 'Stamps with a small trace of being hinged with near full original gum.'
            ],
            [
                'abbreviation' => 'LMM',
                'type' => 'Lightly Mounted Mint',
                'description' => 'As above but the stamps have slightly more evidence of being hinged.'
            ],
            [
                'abbreviation' => 'MM',
                'type' => 'Mounted Mint',
                'description' => 'Stamps which have been more heavily hinged with possible hinge remnants.'
            ],
            [
                'abbreviation' => 'VFU',
                'type' => 'Very Fine Used',
                'description' => 'Used Stamps with a light cancel or Circular Date Stamp (CDS) or equivalent.'
            ],
            [
                'abbreviation' => 'FU',
                'type' => 'Fine Used',
                'description' => 'As above but these stamps are with slightly heavier or smudged cancel.'
            ],
            [
                'abbreviation' => 'GU',
                'type' => 'Good Used',
                'description' => 'Nice collectable stamps with perhaps heavier cancel and minor faults, crease, short perfs etc.'
            ],
            [
                'abbreviation' => 'AU',
                'type' => 'Average Used',
                'description' => 'Nice collectable stamps with perhaps heavier cancel and minor faults, crease, short perfs etc.'
            ]
        ];

        DB::table('gradings')->insert($gradings);
    }
}
