<?php

use Illuminate\Database\Seeder;

class TemporarySetUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory('App\User')->create([
            'name' => 'Michael Perks',
            'email' => 'michael.perks@live.co.uk',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $user->assignRole('admin');
    }
}
