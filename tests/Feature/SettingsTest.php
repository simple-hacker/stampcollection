<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_change_their_password()
    {
        $current_password = 'password';

        $user = factory('App\User')->create([
            'password' => Hash::make($current_password)
            ]);
            
        $this->actingAs($user);

        $new_password = 'secret';

        $this->post(route('password.update', [
                    'current_password' => $current_password,
                    'new_password' => $new_password,
                    'confirm_new_password' => $new_password,
                ]))
                ->assertRedirect(route('password.change'));

        $this->assertTrue(Hash::check($new_password, $user->fresh()->password));
    }

    /** @test */
    public function a_user_must_enter_the_correct_old_password_on_password_change()
    {
        $current_password = 'password';

        $user = factory('App\User')->create([
            'password' => Hash::make($current_password)
            ]);
            
        $this->actingAs($user);

        $new_password = 'secret';

        $this->post(route('password.update', [
                    'current_password' => 'incorrect_password',
                    'new_password' => $new_password,
                    'confirm_new_password' => $new_password,
                ]))
                ->assertSessionHasErrors(['current_password']);
    }

    /** @test */
    public function both_new_passwords_must_match()
    {
        $current_password = 'password';

        $user = factory('App\User')->create([
            'password' => Hash::make($current_password)
            ]);
            
        $this->actingAs($user);

        $this->post(route('password.update', [
                    'current_password' => $current_password,
                    'new_password' => 'secret',
                    'confirm_new_password' => 'notthesame',
                ]))
                ->assertSessionHasErrors(['confirm_new_password']);
    }
}
