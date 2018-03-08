<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

	/**
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function testCreateUser()
	{
		// Creating an temporal user
		return User::create( [
			'name' => 'Temporal',
			'email' => 'temporal@gmail.com',
			'password' => bcrypt('secret'),
		] );
	}

	/**
	 * A basic test example.
	 *
	 * @depends testCreateUser
	 *
	 * @param User $user
	 *
	 * @return void
	 */
    public function testCreateCategory(User $user)
    {
        $temporal_category = [
            'user_id' => $user->id,
            'name' => 'Temporal Category',
        ];

        $category =  $this->post('api/categories', $temporal_category);
        $category->assertStatus(201);
        $this->assertDatabaseHas('categories', $temporal_category);
    }
}
