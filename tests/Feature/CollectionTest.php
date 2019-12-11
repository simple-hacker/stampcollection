<?php

namespace Tests\Feature;

use App\Grading;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    Use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_add_a_stamp_to_their_collection()
    {
        $this->withExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $stamp = factory('App\Stamp')->create();
        $grading = Grading::find(1);
        $value = $this->faker->randomFloat(2, 0, 10);

        $this->post(route('collection.add'), [
            'stamp' => $stamp,
            'stampsToAdd' => [
                [
                    'grading_id' => $grading->id,
                    'value' => $value,
                ],
            ]
        ]);

        $this->assertDatabaseHas('collections', [
                'user_id' => $user->id,
                'stamp_id' => $stamp->id,
                'grading_id' => $grading->id,
                'value' => $value,
            ]);
    }

    /** @test */
    public function a_user_can_remove_a_stamp_from_their_collection()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $stamp = factory('App\Stamp')->create();
        $grading = Grading::find(1);
        $value = $this->faker->randomFloat(2, 0, 10);

        // Add a stamp to the collection
        $this->post(route('collection.add'), [
            'stamp' => $stamp,
            'stampsToAdd' => [
                [
                    'grading_id' => $grading->id,
                    'value' => $value,
                ],
            ]
        ]);

        $this->assertDatabaseHas('collections', [
                'user_id' => $user->id,
                'stamp_id' => $stamp->id,
                'grading_id' => $grading->id,
                'value' => $value,
            ]);

        $stampInCollection = Collection::latest()->first();

        // Visit the same end point and remove stamp from collection.
        $this->delete(route('collection.delete', ['collection' => $stampInCollection]));

        $this->assertDatabaseMissing('collections', [
                'user_id' => $user->id,
                'stamp_id' => $stamp->id,
                'grading_id' => $grading->id,
                'value' => $value,
            ]);
    }

    /** @test */
    public function guests_cannot_add_stamps_to_collection()
    {
        $stamp = factory('App\Stamp')->create();

        $this->post(route('collection.add'))->assertRedirect('login');
    }
}
