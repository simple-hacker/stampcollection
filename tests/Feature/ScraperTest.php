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
        $this->get('scraper/issuesByYear/2019')->assertRedirect('login');

        // Non admin member signs in, expect Forbidden 403 as they don't have the permissions.
        $this->actingAs(factory('App\User')->create());
        $this->get('scraper/issue/22780')->assertStatus(403);
        $this->get('scraper/issuesByYear/2019')->assertStatus(403);
    }

    /** @test */
    public function scraping_an_issue()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        // Visit the Game of Thrones
        $this->get('scraper/issue/22780')->assertRedirect('/');

        $this->assertDatabaseHas('issues', [
            'cgbs_issue' => 22780,
            'title' => 'Game of Thrones',
            'year' => 2018,
        ]);

        // Retrieve the issue because we need to id to find the stamps.
        $issue = Issue::where('cgbs_issue', 22780)->first();

        // Assert that 15 stamps were created.  (15 stamps in Game of Thrones issue 22780)
        $this->assertCount(15, Stamp::where('issue_id', $issue->id)->get());
    }

    /** @test */
    public function scraping_a_year()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        // Visit the Game of Thrones
        $this->get('scraper/issuesByYear/2018')->assertRedirect('/browse/2018');

        // Assert that 22 issues were created.  (22 issues in year 2018)
        $this->assertCount(22, Issue::where('year', 2018)->get());
    }

    /** @test */
    public function scraping_an_invalid_year_expects_404()
    {
        $user = factory('App\User')->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        // Available years are between 1800 and 3000
        $this->get('scraper/issuesByYear/1799')->assertNotFound();
        $this->get('scraper/issuesByYear/3000')->assertNotFound();
    }
}
