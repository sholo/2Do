<?php
namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * @var $model
     */
    private $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUserByID($user_id)
    {

    }
}