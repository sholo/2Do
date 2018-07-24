<?php
namespace App\Repositories;

use App\Category;
use App\User;
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
	 */
	public function __construct()
    {
        $this->transformer = new CategoryTransformer();
    }

    // Singleton
	private function getModelInstance()
	{
		if ( ! $this->model instanceof Category) {
			$this->model = new Category();
		}
		return $this->model;
	}

    /**
     * Index Path
     * @return array
     */
    public function getAllByUser()
    {
        //$user = request()->user();
        $user = User::find(1);
        if ( $user ) {
            $resource = array("data" => [
            	"categories" => $this->transformer->collection($user->categories)
            ], "code" => 200);
        } else {
            $resource = array("data" => ["error" => array("message" => "User doesn't exist")], "code" => 404);
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
	    $model = $this->getModelInstance();
        if ( $user ) {
            $params["user_id"] = $user->id;
	        $model::create($params);
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
	    $model = $this->getModelInstance();

        if ( $user ) {
            $category = $model::where('user_id', $user->id)
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
	    $model = $this->getModelInstance();
        if ( $user ) {
            $category = $model::where('user_id', $user->id)
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
	    $model = $this->getModelInstance();
        if ( $user ) {
            $category = $model::where('user_id', $user->id)
                ->where('id', $category_id)
                ->firstOrFail();

            if ( $category ) {
                $category->delete();
                $response = array("data" => ["message" => "Category deleted successful"], "status" => 201);
            } else {
                $response = array("error" => ["message" => "Category doesn't found"], "status" => 404);
            }
        } else {
            $response = array("error" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
    }
}