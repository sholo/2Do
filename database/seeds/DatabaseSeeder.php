<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    if (App::environment() === 'production') {
		    exit('I just stopped you getting fired. Love Phil');
	    }

	    Artisan::call('migrate:refresh', [
		    '--force' => true
	    ]);

	    Artisan::call('passport:install');

	    $this->call(UsersTableSeeder::class);
	    $this->call(CategoriesTableSeeder::class);
	    $this->call(TasksTableSeeder::class);
    }
}
