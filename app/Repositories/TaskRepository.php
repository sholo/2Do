<?php
namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PrepareResponse;
use App\Task;
use App\Transformers\TaskTransformer;
use App\User;

class TaskRepository extends AbstractRepository
{
	private $transformer;
	private $user;

    public function __construct(Task $model, TaskTransformer $transformer)
    {
        parent::__construct(new PrepareResponse);
	    $this->transformer = new TaskTransformer();
	    $this->user = $this->checkUserExist();
    }

    /**
     * @param $category_id
     * @return array
     */
    public function getAllByCategoryAndUser($category_id)
    {
	    if ( $this->user instanceof User ) {
            $category = ( new Category )
	            ->where('id', $category_id)
	            ->where('user_id', $this->user->id)
	            ->first();

            if ( $category instanceof Category) {
	            return $this->prepare_response->respondWithCollection($category->tasks, new TaskTransformer);
            }
		    return $this->prepare_response->errorNotFound();
        }

        return $this->prepare_response->errorUnauthorized();
    }

    /**
     * @param $params
     * @param $category_id
     * @return array
     */
    public function createByCategoryAndUser($params, $category_id)
    {
	    if ( $this->user instanceof User ) {
            $category = ( new Category )
	            ->where('id', $category_id)
	            ->where('user_id', $this->user->id)
	            ->first();

            if ( $category instanceof Category) {
                $params["category_id"] = $category->id;

	            return $this->prepare_response->respondWithItem(
		            $category->tasks()->create($params),
		            new TaskTransformer
	            );
            }

		    return $this->prepare_response->errorNotFound();
        }

	    return $this->prepare_response->errorUnauthorized();
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
		if ( $this->user instanceof User ) {
			$category = $this->user->categories()
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

		return $this->prepare_response->errorUnauthorized();
	}

	/**
    * Index Path
    * @return array
    */
    public function updateByUserTaskIDandCategoryID($params, $category_id, $task_id)
    {
	    if ( $this->user instanceof User ) {
            $category = ( new Category )
	            ->where('user_id', $this->user->id)
	            ->where('id', $category_id)
	            ->first();

            if ( $category instanceof Category) {
                $task = $category
                    ->tasks()
                    ->where('id',$task_id)
                    ->first();

                if ( $task instanceof Task) {
                    $task->fill($params)->save();
	                return $this->prepare_response->respondWithItem(
		                $task,
		                new TaskTransformer
	                );
                }

	            return $this->prepare_response->errorNotFound();
            }

		    return $this->prepare_response->errorNotFound();
        }

	    return $this->prepare_response->errorUnauthorized();
    }

    /**
     * Index Path
     * @return array
     */
    public function deleteByUserTaskIDandCategoryID($category_id, $task_id)
    {
	    if ( $this->user instanceof User ) {
            $category = ( new Category )
	            ->where('user_id', $this->user->id)
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

	    return $this->prepare_response->errorUnauthorized();
    }
}