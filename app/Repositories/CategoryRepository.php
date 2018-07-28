<?php
namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PrepareResponse;
use App\User;
use App\Transformers\CategoryTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CategoryRepository extends AbstractRepository
{
    private $transformer;
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
    }

    /**
     * Index Path
     * @return array
     */
    public function getAllOfUser()
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

	    $limit = Input::get('limit')? : self::DEFAULT_LIMIT;
	    if ( $limit > self::MAXIMUM_LIMIT ) {
		    $limit = self::MAXIMUM_LIMIT;
	    }

	    return $this->prepare_response->respondWithCollection($user->categories()->paginate($limit), new CategoryTransformer);
    }

	/**
	 * Index Path
	 *
	 * @param array $params
	 *
	 * @return array
	 */
    public function createByUser(array $params)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }
	    $params["user_id"] = $user->id;

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    return $this->prepare_response->responseCreated(
		    $user->categories()->create($params),
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
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

        $category = $user->categories()
                   ->where('user_id', $user->id)
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

	/**
	 * Index Path
	 *
	 * @param array $params
	 * @param $id
	 *
	 * @return array
	 */
    public function updateByUser(array $params, $id)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }
	    $params["user_id"] = $user->id;

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    $category = $user->categories()
	                           ->where('user_id', $user->id)
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
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

        $category = $user->categories()
                               ->where('user_id', $user->id)
                               ->where('id', $id)
                               ->first();

        if ( $category instanceof Category) {
            $category->delete();
            return $this->prepare_response->respondWithoutItem("Category");
        }
	    return $this->prepare_response->errorNotFound();
    }
}