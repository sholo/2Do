<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Faker\Factory as Faker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

	/**
	 * Get All the Categories.
	 *
	 * @return void
	 */
	public function testGetAllCategories()
	{
		$number_of_categories = 10;
		$categories = factory(Category::class, $number_of_categories)->create();

		$response = $this->get('api/categories');
		$response->assertStatus(200);
		$this->assertTrue(count($categories) == $number_of_categories );
	}

	/**
	 * Create and find a Category.
	 *
	 * @return void
	 */
	public function testCreateAndFindCategory()
	{
		$category_name = array(
			'name' => 'Temporal'
		);

		$category = factory(Category::class)->create($category_name);

		$response = $this->get('api/categories/' . $category->id);

		$response->assertStatus(200);
		$this->assertDatabaseHas('categories', $category_name);
	}

	/**
	 * Create a Category.
	 *
	 * @return void
	 */
	public function testCreateCategory()
	{
		$faker = Faker::create();
		$user = factory(User::class)->create();
		$category = array(
			'user_id' => $user->id,
			'name' => $faker->title
		);

		$response = $this->post('api/categories', $category);

		$response->assertStatus(201);
		$this->assertDatabaseHas('categories', $category);
	}

	/**
	 * Create and Delete a Category.
	 *
	 * @return void
	 */
	public function testCreateAndUpdateCategory()
	{
		$category = factory(Category::class)->create();
		$update_category_name = array(
			'name' => 'Category Update'
		);

		$response = $this->patch('api/categories/' . $category->id, $update_category_name);
		$response->assertStatus(200);

		$this->assertDatabaseHas('categories', $update_category_name);
		$this->assertDatabaseMissing('categories', $category->name);
	}

	/**
	 * Create and Delete a Category.
	 *
	 * @return void
	 */
	public function testCreateAndDeleteCategory()
	{
		$category_name = array(
			'name' => 'Temporal'
		);

		$category = factory(Category::class)->create($category_name);
		$this->assertDatabaseHas('categories', $category_name);

		$response = $this->delete('api/categories/' . $category->id);
		$response->assertStatus(201);
		$this->assertDatabaseMissing('categories', $category_name);
	}
}
