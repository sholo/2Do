<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

	    // Disable mass-assignment protection with Laravel
	    Model::unguard();

	    $tables = [
		    'users',
		    'categories',
		    'tasks',
		];

	    Schema::disableForeignKeyConstraints();

		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}

	    Schema::enableForeignKeyConstraints();

	    $this->call(UsersTableSeeder::class);
	    $this->call(CategoriesTableSeeder::class);
	    $this->call(TasksTableSeeder::class);
    }
}
