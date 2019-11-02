<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    public function a_user_can_add_a_stamp_to_their_collection()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $stamp = factory('App\Stamp')->create();

        $this->post('/collection/' . $stamp->id);

        $this->assertDatabaseHas('collections', [
                'user_id' => $user->id, 'stamp_id' => $stamp->id
                ]);
    }

    /** @test */
    public function a_user_can_remove_a_stamp_from_their_collection()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $stamp = factory('App\Stamp')->create();

        // Add a stamp to the collection
        $this->post('/collection/' . $stamp->id);

        $this->assertDatabaseHas('collections', [
                'user_id' => $user->id, 'stamp_id' => $stamp->id
                ]);

        // Visit the same end point and remove stamp from collection.
        $this->delete('/collection/' . $stamp->id);

        $this->assertDatabaseMissing('collections', [
            'user_id' => $user->id, 'stamp_id' => $stamp->id
        ]);
    }

    /** @test */
    public function guests_cannot_add_stamps_to_collection()
    {
        $stamp = factory('App\Stamp')->create();

        $this->post('/collection/' . $stamp->id)->assertRedirect('login');
    }
}
