<?php

namespace Tests\Unit;

use App\Category;
use App\Task;
use App\User;
use Faker\Factory as Faker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Get All the Tasks.
	 *
	 * @return void
	 */
	public function testGetAllTasks()
	{
		$user = factory(User::class)->create();
		Passport::actingAs($user);
		$category = factory(Category::class)->create(["user_id" => $user->id]);

		$number_of_tasks = 10;
		$tasks = factory(Task::class, $number_of_tasks)->create([
			'category_id' => $category->id
		]);

		$response = $this->get('api/categories/' . $category->id . '/tasks');
		$response->assertStatus(200);
		$this->assertTrue(count($tasks) == $number_of_tasks );
	}

	/**
	 * Create and find a Task.
	 *
	 * @return void
	 */
	public function testCreateAndFindTask()
	{
		$user = factory(User::class)->create();
		Passport::actingAs($user);
		$category = factory(Category::class)->create(['user_id' => $user->id]);
		$array_task = array(
			'category_id' => $category->id,
			"description" => "Needs to study more"
		);

		$task = factory(Task::class)->create($array_task);

		$response = $this->get('api/categories/' . $category->id . '/tasks/' . $task->id);

		$response->assertStatus(200);
		$this->assertDatabaseHas('tasks', $array_task);
	}

	/**
	 * Create a Task.
	 *
	 * @return void
	 */
	public function testCreateTask()
	{
		$user = factory(User::class)->create();
		Passport::actingAs($user);
		$category = factory(Category::class)->create(['user_id' => $user->id]);

		$faker = Faker::create();
		$array_task = array(
			'category_id' => $category->id,
			'description' => $faker->text
		);

		$response = $this->post('api/categories/' . $category->id . '/tasks', $array_task);
		$response->assertStatus(201);
		$this->assertDatabaseHas('tasks', $array_task);
	}

	/**
	 * Create and Delete a Category.
	 *
	 * @return void
	 */
	public function testCreateAndUpdateCategory()
	{
		$user = factory(User::class)->create();
		Passport::actingAs($user);

		$array_category = array("user_id" => $user->id);
		$category = factory(Category::class)->create($array_category);

		// Update
		$array_category['name'] = 'Category Update';

		$response = $this->patch('api/categories/' . $category->id, $array_category);
		$response->assertStatus(200);

		$this->assertDatabaseHas('categories', $array_category);
		$this->assertDatabaseMissing('categories', ["name" => $category->name]);
	}

	/**
	 * Create and Delete a Category.
	 *
	 * @return void
	 */
	public function testCreateAndDeleteCategory()
	{
		$user = factory(User::class)->create();
		Passport::actingAs($user);

		$array_category = array(
			'user_id' => $user->id,
			'name' => 'Temporal'
		);

		$category = factory(Category::class)->create($array_category);
		$this->assertDatabaseHas('categories', $array_category);

		$response = $this->delete('api/categories/' . $category->id);
		$response->assertStatus(201);
		$this->assertDatabaseMissing('categories', $array_category);
	}
}
