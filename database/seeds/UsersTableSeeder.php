<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $number_users = 1;
	    factory(App\User::class, $number_users)
		    ->create()
		    ->each(function ($user) {
			    $user->createToken('MyApp')->accessToken;
		    });
    }
}
