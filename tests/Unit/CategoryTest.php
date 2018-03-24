<?php

namespace Tests\Unit;

use App\Category;
use App\User;
use Faker\Factory as Faker;
use Laravel\Passport\Passport;
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
	    $user = factory(User::class)->create();
        Passport::actingAs($user);

		$number_of_categories = 10;
		$categories = factory(Category::class, $number_of_categories)->create([
		    'user_id' => $user->id
        ]);

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
        $user = factory(User::class)->create();
        Passport::actingAs($user);

		$array_category = array(
		    'user_id' => $user->id,
			'name' => 'Temporal'
		);

		$category = factory(Category::class)->create($array_category);

		$response = $this->get('api/categories/' . $category->id);

		$response->assertStatus(200);
		$this->assertDatabaseHas('categories', $array_category);
	}

	/**
	 * Create a Category.
	 *
	 * @return void
	 */
	public function testCreateCategory()
	{
        $user = factory(User::class)->create();
        Passport::actingAs($user);

		$faker = Faker::create();
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
