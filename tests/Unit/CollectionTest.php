<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    Use RefreshDatabase;
   
    /** @test */
    public function a_stamp_can_be_added_to_collection_via_user()
    {
        $user = factory('App\User')->create();
        $stamp = factory('App\Stamp')->create();

        $this->assertDatabaseMissing('collections', ['user_id' => $user->id, 'stamp_id' => $stamp->id]);

        $stamp->users()->attach($user);

        $this->assertDatabaseHas('collections', ['user_id' => $user->id, 'stamp_id' => $stamp->id]);
    }

    /** @test */
    public function a_user_can_add_a_stamp_to_a_collection()
    {
        $user = factory('App\User')->create();
        $stamp = factory('App\Stamp')->create();

        $this->assertDatabaseMissing('collections', ['user_id' => $user->id, 'stamp_id' => $stamp->id]);

        $user->stamps()->attach($stamp);

        $this->assertDatabaseHas('collections', ['user_id' => $user->id, 'stamp_id' => $stamp->id]);
    }
}
