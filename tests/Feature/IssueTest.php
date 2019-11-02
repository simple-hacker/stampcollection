<?php

namespace Tests\Feature;

use App\Issue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function admins_can_add_an_issue()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'year' => 2018,
            'release_date' => '2018-01-05',
        ];

        $this->post('issue', $attributes)->assertOk();

        $this->assertDatabaseHas('issues', $attributes);
    }

    /** @test */
    public function members_cannot_add_issues()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'year' => 2018,
            'release_date' => '2018-01-05',
        ];

        $this->post('issue', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('issues', $attributes);
    }

    /** @test */
    public function guests_cannot_add_an_issue()
    {
        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'year' => 2018,
            'release_date' => '2018-01-05',
        ];

        $response = $this->post('issue', $attributes);

        $response->assertRedirect('login');

        $this->assertCount(0, Issue::all());
    }
}
