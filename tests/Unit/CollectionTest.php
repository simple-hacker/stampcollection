<?php

namespace Tests\Unit;

use App\Grading;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    Use RefreshDatabase, WithFaker;

    /** @test */
    public function add_to_collection_via_users_stamps()
    {
        $user = factory('App\User')->create();
        $stamp = factory('App\Stamp')->create();

        $this->assertDatabaseMissing('collections', ['user_id' => $user->id, 'stamp_id' => $stamp->id]);

        $value = $this->faker->randomFloat(2, 0, 10);

        $user->stamps()->attach($stamp, [
            'grading_id' => 1,
            'value' => $value
        ]);

        $this->assertDatabaseHas('collections', [
            'user_id' => $user->id,
            'stamp_id' => $stamp->id,
            'grading_id' => 1,
            'value' => $value
        ]);
    }
}
