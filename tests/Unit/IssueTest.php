<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IssueTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    public function an_issue_has_a_collection_of_stamps()
    {
        $issue = factory('App\Issue')->create();

        // Create 5 stamps for this issue
        factory('App\Stamp', 5)->create([
            'issue_id' => $issue->id,
        ]);

        $this->assertInstanceOf(Collection::class, $issue->stamps);
        $this->assertCount(5, $issue->stamps);
    }

    /** @test */
    public function an_issue_has_a_slug_of_a_title()
    {
        $issue = factory('App\Issue')->create(['title' => 'Game of Thrones']);

        $this->assertEquals('game-of-thrones', $issue->slug);
    }

    /** @test */
    public function an_issue_has_a_path()
    {
        $issue = factory('App\Issue')->create(['id' => 1, 'title' => 'Game of Thrones']);

        $this->assertEquals('/catalogue/1/game-of-thrones', $issue->path());
    }
}
