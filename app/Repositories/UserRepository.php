<?php
namespace App\Repositories;

use App\User;

class UserRepository extends AbstractRepository
{
    /**
     * @var $model
     */
    private $model;
    public function __construct(User $model)
    {
        parent::__construct();
        $this->model = $model;
    }
}