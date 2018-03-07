<?php

namespace Tests\Feature;

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
    public function testExample()
    {
        // Creating an temporal user
        $temporal_user = [
            'name'      => 'Temporal',
            'email'     => 'temporal@gmail.com',
            'password'  => 'secret'
        ];
        $user =  $this->post('api/users', $temporal_user);
        $user->assertStatus(201);
        $this->assertDatabaseHas('users', $temporal_user);
        $this->assertTrue(true);

        $temporal_category = [
            'user_id' => $user->id,
            'name' => 'Temporal Category',
        ];

        $category =  $this->post('api/categories', $temporal_category);
        $category->assertStatus(201);
        $this->assertDatabaseHas('categories', $temporal_category);
        $this->assertTrue(true);
    }
}
