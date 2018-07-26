<?php
namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PrepareResponse;
use App\User;
use Illuminate\Http\Request;
use App\Transformers\CategoryTransformer;
use Illuminate\Support\Facades\Input;

class CategoryRepository extends AbstractRepository
{
    private $transformer;
    private $user;
	const RULES_VALIDATIONS = array(
		'user_id' => 'required|integer',
		'name' => 'required|max:191'
	);

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

    /**
     * Index Path
     * @return array
     */
    public function getAllOfUser()
    {
	    $limit = Input::get('limit')? : self::DEFAULT_LIMIT;
	    if ( $limit > self::MAXIMUM_LIMIT ) {
		    $limit = self::MAXIMUM_LIMIT;
	    }

	    if ( $this->user instanceof User ) {
		    return $this->prepare_response->respondWithCollection($this->user->categories()->paginate($limit), new CategoryTransformer);
	    }
	    return $this->prepare_response->errorUnauthorized();
    }

	/**
	 * Index Path
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
    public function createByUser(Request $request)
    {
	    $params = $request->all();
	    if ( ! $this->user instanceof User ) {
		    return $this->prepare_response->errorUnauthorized();
	    }
	    $params["user_id"] = $this->user->id;

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    return $this->prepare_response->responseCreated(
	        $this->user->categories()->create($params),
		    new CategoryTransformer
	    );
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
	        $category = $this->user->categories()
	                   ->where('user_id', $this->user->id)
	                   ->where('id', $id)
	                   ->first();

	        if ( $category instanceof Category) {
		        return $this->prepare_response->respondWithItem(
			        $category,
			        new CategoryTransformer
		        );
	        }

	        return $this->prepare_response->errorNotFound();
        }

	    return $this->prepare_response->errorUnauthorized();
    }

	/**
	 * Index Path
	 *
	 * @param Request $request
	 * @param $id
	 *
	 * @return array
	 */
    public function updateByUser(Request $request, $id)
    {
    	$params = $request->all();
	    if ( ! $this->user instanceof User ) {
		    return $this->prepare_response->errorUnauthorized();
	    }
	    $params["user_id"] = $this->user->id;

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    $category = $this->user->categories()
	                           ->where('user_id', $this->user->id)
	                           ->where('id', $id)
	                           ->first();

	    if ( ! $category instanceof Category) {
		    return $this->prepare_response->errorNotFound();
	    }

	    $category->fill($params)->save();
	    return $this->prepare_response->respondWithItem(
		    $category,
		    new CategoryTransformer
	    );

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
	            $category->delete();
	            return $this->prepare_response->respondWithoutItem("Category");
            }
		    return $this->prepare_response->errorNotFound();
        }

	    $this->prepare_response->errorUnauthorized();
    }
}