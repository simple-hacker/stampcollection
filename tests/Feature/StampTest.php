<?php

namespace Tests\Feature;

use App\Stamp;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class StampTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function create_a_stamp_page_loads_for_authorized_users()
    {
        $issue = factory('App\Issue')->create();
        // Guests get redirected.
        $this->get(route('create.stamp', ['issue' => $issue]))->assertRedirect('login');

        //Members receive 403.
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $this->get(route('create.stamp', ['issue' => $issue]))->assertForbidden();

        //Admins receive Ok 200.
        $user->assignRole('admin');
        $this->get(route('create.stamp', ['issue' => $issue]))->assertOk();
    }

    /** @test */
    public function unauthorized_users_cannot_add_stamps()
    {
        $issue = factory('App\Issue')->create();
        $stamp = factory('App\Stamp')->raw(['issue_id' => $issue->id]);

        // Guests get redirected.
        $this->post(route('add.stamp', ['issue' => $issue]), $stamp)->assertRedirect('login');

        //Members receive 403.
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $this->post(route('add.stamp', ['issue' => $issue]), $stamp)->assertForbidden();
    }

    /** @test */
    public function admins_can_add_stamps_to_issue()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $issue = factory('App\Issue')->create();

        $attributes = [
            'title' => 'New Stamp',
            'description' => 'The latest stamp in this issue',
        ];

        $this->post(route('add.stamp', ['issue' => $issue]), $attributes)
            ->assertRedirect(route('catalogue.issue', ['issue' => $issue, 'slug' => $issue->slug]));

        $this->assertDatabaseHas('stamps', $attributes);

        // Make sure the stamp was added to the correct issue.
        $stamp = Stamp::first();
        $this->assertEquals($issue->id, $stamp->issue_id);
    }

    /** @test */
    public function issue_must_exist_to_add_a_stamp()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        // Issue with id 999 doesn't exist.  So if we visit /issue/999/create or post data to we should receive a 404.
        $this->get(route('create.stamp', ['issue' => 999]))->assertNotFound();

        // If we send data to add a stamp to an issue which doesn't exist we should receive a 404.
        $stamp = factory('App\Stamp')->raw(['issue_id' => 999]);
        $this->post(route('add.stamp', ['issue' => 999]), $stamp)->assertNotFound();
    }

    /** @test */
    public function admins_can_edit_a_stamp()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $issue = factory('App\Issue')->create();
        $stamp = factory('App\Stamp')->create(['issue_id' => $issue->id]);

        // Assert the edit Stamp form page loads.
        $this->get(route('edit.stamp', ['stamp' => $stamp]))->assertOk();

        $attributes = [
            'title' => 'New Stamp Title',
            'description' => 'New Stamp Description',
        ];

        $this->post(route('update.stamp', ['stamp' => $stamp]), $attributes)
                ->assertRedirect(route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));

        $this->assertDatabaseHas('stamps', $attributes);

        $stamp = Stamp::find($stamp->id);

        $this->assertEquals($attributes['title'], $stamp->title);
        $this->assertEquals($attributes['description'], $stamp->description);
    }

    /** @test */
    public function admins_can_delete_a_stamp()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        $stamp = factory('App\Stamp')->create();
        $this->assertCount(1, Stamp::all());
        $this->assertDatabaseHas('stamps', $stamp->toArray());

        $this->delete(route('delete.stamp', ['stamp' => $stamp]))
            ->assertRedirect(route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]));
    }

    /** @test */
    public function an_admin_can_add_an_image_to_a_stamp()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        Storage::fake('public');

        $issue = factory('App\Issue')->create();
        $stamp = factory('App\Stamp')->raw([
            'issue_id' => $issue->id
        ]);

        $this->post(route('add.stamp', ['issue' => $issue]), $stamp);

        $folder = substr(md5($issue->id . $issue->title), -5) . "_" . Str::slug($issue->title);
        $filename = substr(md5($stamp['image']->getClientOriginalName()), -5) . "_" . Str::slug($stamp['title']) . "." . $stamp['image']->getClientOriginalExtension();
        $path = "{$folder}/{$filename}";

        Storage::disk('public')->assertExists('stamps/' . $path);
    }

    /** @test */
    public function an_admin_cannot_add_an_invalid_image_type()
    {
        $user = tap(factory('App\User')->create())->assignRole('admin');
        $this->actingAs($user);

        Storage::fake('public');

        $issue = factory('App\Issue')->create();
        $stamp = factory('App\Stamp')->raw([
            'issue_id' => $issue->id,
            'image' => UploadedFile::fake('invalid.pdf')
        ]);

        // Assert cannot upload invalid file to new Stamp
        $this->post(route('add.stamp', ['issue' => $issue]), $stamp)
            ->assertSessionHasErrors('image');

        // Persist a stamp to the database to be updated.
        $stamp = factory('App\Stamp')->create([
            'issue_id' => $issue->id
        ]);

        // Assert cannot upload invalud file when updating a stamp.
        $invalid_image = UploadedFile::fake('invalid.pdf');

        $this->post(route('update.stamp', ['stamp' => $stamp]), [
                'title' => $stamp->title,
                'image' => $invalid_image,
            ])
            ->assertSessionHasErrors('image');
    }
}
