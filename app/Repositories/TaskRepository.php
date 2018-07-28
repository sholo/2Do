<?php
namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PrepareResponse;
use App\Task;
use App\Transformers\TaskTransformer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class TaskRepository extends AbstractRepository
{
	private $transformer;
	const RULES_VALIDATIONS = array(
		'category_id' => 'required|integer',
		'description' => 'required|string'
	);

    public function __construct(Task $model, TaskTransformer $transformer)
    {
        parent::__construct(new PrepareResponse);
	    $this->transformer = new TaskTransformer();
    }

    /**
     * @param $category_id
     * @return array
     */
    public function getAllByCategoryAndUser($category_id)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

	    $limit = Input::get('limit')? : self::DEFAULT_LIMIT;
	    if ( $limit > self::MAXIMUM_LIMIT ) {
		    $limit = self::MAXIMUM_LIMIT;
	    }

        $category = ( new Category )
            ->where('id', $category_id)
            ->where('user_id', $user->id)
            ->first();

        if ( $category instanceof Category) {
            return $this->prepare_response->respondWithCollection($category->tasks()->paginate($limit), new TaskTransformer);
        }
	    return $this->prepare_response->errorNotFound();
    }

	/**
	 * @param array $params
	 * @param $category_id
	 *
	 * @return array
	 */
    public function createByCategoryAndUser(array $params, $category_id)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

        $category = ( new Category )
            ->where('id', $category_id)
            ->where('user_id', $user->id)
            ->first();

        if ( ! $category instanceof Category) {
	        return $this->prepare_response->errorNotFound();
        }
	    $params["category_id"] = $category->id;

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    return $this->prepare_response->responseCreated(
		    $category->tasks()->create($params),
		    new TaskTransformer
	    );

    }

	/**
	 * Index Path
	 *
	 * @param $category_id
	 * @param $task_id
	 *
	 * @return array
	 */
	public function showByUserTaskIDAndCategoryID($category_id, $task_id)
	{
		$user = Auth::user();
		if ( ! $user instanceof User) {
			return $this->prepare_response->errorUnauthorized();
		}

		$category = $user->categories()
		             ->where('id',$category_id)
		             ->first();

		if ( $category instanceof Category) {
			$task = $category
				->tasks()
				->where('id',$task_id)
				->first();

			if ( $task instanceof Task) {
				return $this->prepare_response->respondWithItem(
					$task,
					new TaskTransformer
				);
			}

			return $this->prepare_response->errorNotFound();
		}

		return $this->prepare_response->errorNotFound();
	}

	/**
	 * Index Path
	 *
	 * @param array $params
	 * @param $category_id
	 * @param $task_id
	 *
	 * @return array
	 */
    public function updateByUserTaskIDandCategoryID(array $params, $category_id, $task_id)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

        $category = ( new Category )
            ->where('user_id', $user->id)
            ->where('id', $category_id)
            ->first();

        if ( ! $category instanceof Category) {
            return $this->prepare_response->errorNotFound();
        }
	    $params["category_id"] = $category->id;

	    $task = $category
		    ->tasks()
		    ->where('id',$task_id)
		    ->first();

	    if ( ! $task instanceof Task) {
		    return $this->prepare_response->errorNotFound();
	    }

	    if ( ! $this->setValidationRules(self::RULES_VALIDATIONS)->validateParameters($params) ) {
		    return $this->prepare_response->errorWrongArgs();
	    }

	    $task->fill($params)->save();
	    return $this->prepare_response->respondWithItem(
		    $task,
		    new TaskTransformer
	    );
    }

	/**
	 * Index Path
	 *
	 * @param $category_id
	 * @param $task_id
	 *
	 * @return array
	 */
    public function deleteByUserTaskIDandCategoryID($category_id, $task_id)
    {
	    $user = Auth::user();
	    if ( ! $user instanceof User) {
		    return $this->prepare_response->errorUnauthorized();
	    }

        $category = ( new Category )
            ->where('user_id', $user->id)
            ->where('id', $category_id)
            ->first();

        if ( $category instanceof Category) {
            $task = $category
                ->tasks()
                ->where('id',$task_id)
                ->first();

            if ( $task instanceof Task) {
                $task->delete();
                return $this->prepare_response->respondWithoutItem("Task");
            }

            return $this->prepare_response->errorNotFound();
        }

	    return $this->prepare_response->errorNotFound();
    }
}