<?php

use App\User;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$number_categories = rand(3, 5);
	    $users = User::all();

	    if ( ! empty($users) ) {
	    	foreach ( $users as $user ){
			    factory(App\Category::class, $number_categories)->create([
				    'user_id' => $user->id,
			    ]);
		    }
	    } else {
		    factory(App\Category::class, $number_categories)->create();
	    }
    }
}
