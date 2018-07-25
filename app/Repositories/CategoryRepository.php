<?php
namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PrepareResponse;
use App\User;
use App\Transformers\CategoryTransformer;


class CategoryRepository extends AbstractRepository
{
    /**
     * @var $model
     */
    private $transformer;
    private $user;

	/**
	 * CategoryRepository constructor.
	 *
	 */
	public function __construct()
    {
        parent::__construct(new PrepareResponse);
        $this->transformer = new CategoryTransformer();
        $this->user = $this->checkUserExist();
    }

	private function checkUserExist()
	{
		return ( new \App\User )->find(1);

		$user = request()->user();
		if ( $user instanceof User ) {
			return $user;
		}
		return null;
	}

    /**
     * Index Path
     * @return array
     */
    public function getAllOfUser()
    {
	    if ( $this->user instanceof User ) {
		    return $this->prepare_response->respondWithCollection($this->user->categories, new CategoryTransformer);
	    }
	    return $this->prepare_response->errorUnauthorized();
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
	    if ( $this->user instanceof User ) {
		    $params["user_id"] = $this->user->id;
		    return $this->user->categories()->create($params);
	    }
	    return null;
    }

	/**
	 * Index Path
	 *
	 * @param $id
	 *
	 * @return array
	 */
    public function showCategoryOfUser($id)
    {
        if ( $this->user instanceof User ) {
            return $this->user->categories()
                              ->where('user_id', $this->user->id)
                              ->where('id', $id)
                              ->first();
        }

        return null;
    }

	/**
	 * Index Path
	 *
	 * @param $params
	 * @param $id
	 *
	 * @return array
	 */
    public function updateByUser($params, $id)
    {
	    if ( $this->user instanceof User ) {
		    $category = $this->user->categories()
		                           ->where('user_id', $this->user->id)
		                           ->where('id', $id)
		                           ->first();

		    if ( $category instanceof Category) {
			    $category->fill($params)->save();
			    return $category;
		    }
		    return null;
	    }

	    return null;
    }

	/**
	 * Index Path
	 *
	 * @param $id
	 *
	 * @return array
	 * @throws \Exception
	 */
    public function deleteByUser($id)
    {

	    if ( $this->user instanceof User ) {
            $category = $this->user->categories()
                                   ->where('user_id', $this->user->id)
                                   ->where('id', $id)
                                   ->first();

            if ( $category instanceof Category) {
                return $category->delete();
            }
            return null;
        }

        return null;
    }
}