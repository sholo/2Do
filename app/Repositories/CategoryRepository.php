<?php
namespace App\Repositories;

use App\Category;
use App\User;

class CategoryRepository
{
    /**
     * @var $model
     */
    private $model;
    private $transformer;

    public function __construct(Category $model, CategoryTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Index Path
     * @param $user_id
     * @return array
     */
    public function getAllByUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $resource = $this->transformer->collection($user->categories);
        return $resource;
    }

    /**
     * Index Path
     * @param $user_id
     * @return array
     */
    public function createByUser($user_id, $params)
    {
        $user = Category::create($params);
        $resource = $this->transformer->collection($user->categories);
        return $resource;
    }
}