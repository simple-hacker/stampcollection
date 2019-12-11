<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    public function can_view_issues_for_a_given_year()
    {
        $issue = factory('App\Issue')->create(['year' => 2019]);

        $this->get('catalogue/2019')
            ->assertOk()
            ->assertSee($issue->title);
    }

    /** @test */
    public function cannot_catalogue_an_invalid_year()
    {
        $this->get('/catalogue/3000')->assertNotFound();
    }

    /** @test */
    public function can_view_a_valid_issue()
    {
        $this->withoutExceptionHandling();

        // I want URL to be /catalogue/id/slug
        // e.g /catalogue/29/game-of-thrones/
        $issue = factory('App\Issue')->create(['title' => 'Game of Thrones']);

        $this->get($issue->path())
            ->assertOk()
            ->assertSee($issue->title)
            ->assertSee($issue->description);
    }

    /** @test */
    public function abort_if_id_and_slug_dont_match()
    {
        factory('App\Issue')->create([
            'id' => 25,
            'title' => 'Game of Thrones'
        ]);

        // Valid id but invalid slug
        $this->get('/catalogue/25/invalid-slug')->assertNotFound();

        // Valid slug but invalid id
        $this->get('/catalogue/22/game-of-thrones')->assertNotFound();

        // Both are valid
        $this->get('/catalogue/25/game-of-thrones')->assertOk();
    }
}
