<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StampTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function admins_can_add_stamps()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $issue = factory('App\Issue')->create();

        $attributes = [
            'title' => 'Jon Snow',
            'description' => $this->faker->sentence(),
            'image_url' => 'https://www.collectgbstamps.co.uk/images/contributors/royalmail/2018_8998_l.jpg',
            'price' => $this->faker->randomFloat(2, 0, 5),
            'issue_id' => $issue->id,
        ];

        $this->post('stamp', $attributes)->assertOk();

        $this->assertDatabaseHas('stamps', $attributes);
    }

    /** @test */
    public function members_cannot_add_stamps()
    {
        $this->actingAs(factory('App\User')->create());

        $issue = factory('App\Issue')->create();

        $attributes = [
            'title' => 'Jon Snow',
            'description' => $this->faker->sentence(),
            'image_url' => 'https://www.collectgbstamps.co.uk/images/contributors/royalmail/2018_8998_l.jpg',
            'price' => $this->faker->randomFloat(2, 0, 5),
            'issue_id' => $issue->id,
        ];

        $this->post('stamp', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('stamps', $attributes);
    }

    /** @test */
    public function a_guest_cannot_add_a_stamp()
    {
        $attributes = [
            'title' => 'Jon Snow',
            'description' => $this->faker->sentence(),
            'image_url' => 'https://www.collectgbstamps.co.uk/images/contributors/royalmail/2018_8998_l.jpg',
            'price' => $this->faker->randomFloat(2, 0, 5),
        ];

        $this->post('stamp', $attributes)->assertRedirect('login');
    }
}
