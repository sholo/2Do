<?php

use App\Category;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = Category::all();
    	if ( ! empty($categories) ) {
		    foreach ( $categories as $category ) {
			    // This to have different number of task by category
			    $number_tasks = rand(4, 8);

			    factory(App\Task::class, $number_tasks)->create([
				    'category_id' => $category->id,
			    ]);
		    }
	    } else {
		    factory(App\Task::class, 10)->create();
	    }
    }
}
