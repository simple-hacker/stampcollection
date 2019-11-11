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
        $this->withExceptionHandling();

        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'release_date' => '2018-11-01',
        ];

        $this->post('issue', $attributes);

        $this->assertDatabaseHas('issues', $attributes);
    }

    /** @test */
    public function members_and_guests_cannot_add_issues()
    {
        $attributes = [
            'cgbs_issue' => 22523,
            'title' => 'Game of Thrones',
            'description' => $this->faker->sentence(),
            'year' => 2018,
            'release_date' => '2018-01-05',
        ];

        // Guests should be redirected
        $this->post('issue', $attributes)->assertRedirect('login');

        // Registered members should receive an Unauthenticated because only admins can do this.
        $this->actingAs(factory('App\User')->create());
        $this->post('issue', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('issues', $attributes);
    }

    /** @test */
    public function create_an_issue_page_loads_for_authorized_users()
    {
        // Guests get redirected.
        $this->get(route('create.issue'))->assertRedirect('login');
        
        //Members receive a 403 Unauthenticated.
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $this->get(route('create.issue'))->assertStatus(403);
        
        //Admins receive Ok.
        $user->assignRole('admin');
        $this->get(route('create.issue'))->assertOk();
    }

    /** @test */
    public function members_and_guests_cannot_update_issues()
    {
        $issue = factory('App\Issue')->create();

        $attributes = [
            'title' => 'New Title',
            'description' => 'New Description',
        ];

        // Guests should be redirected
        $this->post(route('update.issue', $issue), $attributes)->assertRedirect('login');

        // Registered members should receive an Unauthenticated because only admins can do this.
        $this->actingAs(factory('App\User')->create());
        $this->post(route('update.issue', $issue), $attributes)->assertStatus(403);
    }

    /** @test */
    public function admins_can_update_issues()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $issue = factory('App\Issue')->create();

        $attributes = [
            'title' => 'New Title',
            'release_date' => '2019-11-01',
            'description' => 'New Description',
        ];

        $this->post(route('update.issue', $issue), $attributes)->assertRedirect($issue->fresh()->path());

        $this->assertDatabaseHas('issues', $attributes);
    }

    /** @test */
    public function creating_unique_issues()
    {
        // A issue is unique between the title, and release_date

        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $issue = factory('App\Issue')->raw(['cgbs_issue' => null]); // Make one without a cgbs_issue

        $this->post(route('add.issue'), $issue);
        $this->assertCount(1, Issue::all());

        $this->assertDatabaseHas('issues', $issue);
        
        // If I make another post request I should still only have one.
        // Same title and release date but different other attributes should result in updating the old issue but with new attributes
        // So we don't get a duplicated title+release_date
        $issue['cgbs_issue'] = 2222;
        $issue['description'] = 'New Description';
        
        $this->post(route('add.issue'), $issue);
        $this->assertCount(1, Issue::all());

        $this->assertDatabaseHas('issues', $issue);
    }
}
