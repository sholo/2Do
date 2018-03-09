<?php

namespace Tests\Feature;

use App\User;
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
        //$faker = Faker\Factory::create();
        $user = factory(User::class)->create();
        $category = array(
            'user_id' => $user->id,
            'name' => 'Category Temporal'
        );

        $response = $this->post('api/categories', $category);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $category);
    }
}
