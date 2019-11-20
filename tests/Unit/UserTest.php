<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    Use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_has_a_collection_of_stamps()
    {
        $user = factory('App\User')->create();
        $stamp = factory('App\Stamp')->create();

        $value = $this->faker->randomFloat(2, 0, 10);

        $user->stamps()->attach($stamp, [
            'grading_id' => 1,
            'value' => $value
        ]);

        $collection = $user->collection()->latest()->first();

        $this->assertInstanceOf('App\Collection', $collection);
    }
}
