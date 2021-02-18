<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'user_level' => 'superadmin'
        ]);
        factory(User::class, 20)->create();
    }
}
