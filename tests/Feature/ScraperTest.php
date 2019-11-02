<?php

namespace Tests\Feature;

use App\Issue;
use App\Stamp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScraperTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    public function only_admins_can_scrap()
    {
        // Guests get redirected.
        $this->get('scraper/issue/22780')->assertRedirect('login');

        // Non admin member signs in, expect Forbidden 403 as they don't have the permissions.
        $this->actingAs(factory('App\User')->create());
        $this->get('scraper/issue/22780')->assertStatus(403);
    }

    /** @test */
    public function scraping_an_issue()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        // Visit the Game of Thrones
        $this->get('scraper/issue/22780')->assertOk();

        $this->assertDatabaseHas('issues', [
            'cgbs_issue' => 22780,
            'title' => 'Game of Thrones',
            'year' => 2018,
            'release_date' => '2018-01-23'
        ]);

        // Retrieve the issue because we need to id to find the stamps.
        $issue = Issue::where('cgbs_issue', 22780)->first();

        // Assert that 15 stamps were created.  (15 stamps in Game of Thrones issue 22780)
        $this->assertCount(15, Stamp::where('issue_id', $issue->id)->get());
    }
}
