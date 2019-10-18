<?php

namespace Tests\Feature;

use App\StampSet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StampSetTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A test to ensure Stamp Sets can be persisted to the database
     *
     * @return void
     */
    public function test_a_stamp_set_can_be_created()
    {
        $data = [
            'id' => 22780,
            'title' => 'Game of Thrones',
            'year' => 2019,
            'description' => $this->faker->sentence(),
        ];

        StampSet::create($data);

        $this->assertDatabaseHas('stamp_sets', $data);
    }
}
