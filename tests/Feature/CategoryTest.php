<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory as Faker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
	 * A basic test example.
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
}
