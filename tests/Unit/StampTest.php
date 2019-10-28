<?php

namespace Tests\Unit;

use App\Issue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StampTest extends TestCase
{
    Use WithFaker, RefreshDatabase;

    /** @test */
    public function a_stamp_belongs_to_an_issue()
    {
        $stamp = factory('App\Stamp')->create();

        // dd($stamp->issue);

        $this->assertInstanceOf(Issue::class, $stamp->issue);
    }
    
}
