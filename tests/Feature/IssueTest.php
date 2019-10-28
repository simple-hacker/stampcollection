<?php

namespace Tests\Feature;

use App\User;
use App\Issue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function an_issue_can_be_created_by_auth_user()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'year' => 2018,
            'release_date' => '2018-01-05',
        ];

        $response = $this->post('issue', $attributes);
        $response->assertOk();

        $this->assertDatabaseHas('issues', $attributes);
    }

    /** @test */
    public function guests_cannot_add_an_issue()
    {
        // $this->withoutExceptionHandling();

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
