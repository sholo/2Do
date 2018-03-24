<?php
namespace App\Repositories;

use App\Category;
use App\Transformers\CategoryTransformer;

class CategoryRepository
{
    /**
     * @var $model
     */
    private $model;
    private $transformer;

	/**
	 * CategoryRepository constructor.
	 *
	 * @param Category $model
	 * @param CategoryTransformer $transformer
	 */
	public function __construct(Category $model, CategoryTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Index Path
     * @return array
     */
    public function getAllByUser()
    {
        $user = request()->user();
        if ( $user ) {
            $resource = $this->transformer->collection($user->categories);
        } else {
            $resource = array("message" => "User doesn't exist");
        }
        return $resource;
    }

	/**
	 * Index Path
	 *
	 * @param $params
	 *
	 * @return array
	 */
    public function createByUser($params)
    {
        $user = request()->user();
        if ( $user ) {
            $params["user_id"] = $user->id;
            $this->model::create($params);
            $response = array("text" => ["message" => "category_created"], "status" => 201);
        } else {
            $response = array("text" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
    }

	/**
	 * Index Path
	 *
	 * @param $category_id
	 *
	 * @return array
	 */
    public function showByUserAndCategoryID($category_id)
    {
        $user = request()->user();

        if ( $user ) {
            $category = $this->model::where('user_id', $user->id)
                ->where('id', $category_id)
                ->firstOrFail();

            if ( $category ) {
                $response = $this->transformer->item($category);
            } else {
                $response = array("message" => "Category doesn't found");
            }
        } else {
            $response = array("message" => "User doesn't exist");
        }

        return $response;
    }

	/**
	 * Index Path
	 *
	 * @param $params
	 * @param $category_id
	 *
	 * @return array
	 */
    public function updateByUser($params, $category_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = $this->model::where('user_id', $user->id)
                                    ->where('id', $category_id)
                                    ->firstOrFail();

            if ( $category ) {
                $category->fill($params)->save();
                $response = $this->transformer->item($category);
            } else {
                $response = array("message" => "Category doesn't found");
            }
        } else {
            $response = array("message" => "User doesn't exist");
        }

        return $response;
    }

	/**
	 * Index Path
	 *
	 * @param $category_id
	 *
	 * @return array
	 * @throws \Exception
	 */
    public function deleteByUser($category_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = $this->model::where('user_id', $user->id)
                ->where('id', $category_id)
                ->firstOrFail();

            if ( $category ) {
                $category->delete();
                $response = array("text" => ["message" => "Category deleted successful"], "status" => 201);
            } else {
                $response = array("text" => ["message" => "Category doesn't found"], "status" => 404);
            }
        } else {
            $response = array("text" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
    }
}