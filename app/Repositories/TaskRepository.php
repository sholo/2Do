<?php
namespace App\Repositories;

use App\Category;
use App\Task;
use App\Transformers\TaskTransformer;

class TaskRepository extends AbstractRepository
{
    /**
     * @var $model
     */
    private $model;
    private $transformer;

    public function __construct(Task $model, TaskTransformer $transformer)
    {
        parent::__construct();
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * @param $category_id
     * @return array
     */
    public function getAllByCategoryAndUser($category_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = Category::where('id', $category_id)
                ->where('user_id', $user->id)
                ->first();

            if ( $category ) {
                $response = $this->transformer->collection($category->tasks);
            } else {
                $response = array("text" => ["message" => "Category doesn't exist"], "status" => 404);
            }
        } else {
            $response = array("text" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
    }

    /**
     * @param $params
     * @param $category_id
     * @return array
     */
    public function createByCategoryAndUser($params, $category_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = Category::where('id', $category_id)
                ->where('user_id', $user->id)
                ->first();

            if ( $category ) {
                $params["category_id"] = $category->id;
                $this->model::create($params);
                $response = array("text" => ["message" => "task_created"], "status" => 201);
            } else {
                $response = array("text" => ["message" => "Category doesn't exist"], "status" => 404);
            }
        } else {
            $response = array("text" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
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
		$user = request()->user();

		if ( $user ) {
			$category = $user->categories()
			             ->where('id',$category_id)
			             ->firstOrFail();

			if ( $category ) {
				$task = $category
					->tasks()
					->where('id',$task_id)
					->firstOrFail();

				if ( $task ) {
					$response = $this->transformer->item($task);
				} else {
					$response = array("message" => "Task doesn't found");
				}
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
    * @return array
    */
    public function updateByUserTaskIDandCategoryID($params, $category_id, $task_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = Category::where('user_id', $user->id)
                ->where('id', $category_id)
                ->firstOrFail();

            if ( $category ) {
                $task = $category
                    ->tasks()
                    ->where('id',$task_id)
                    ->firstOrFail();

                if ( $task ) {
                    $task->fill($params)->save();
                    $response = $this->transformer->item($task);
                } else {
                    $response = array("message" => "Task doesn't found");
                }
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
     * @return array
     */
    public function deleteByUserTaskIDandCategoryID($category_id, $task_id)
    {
        $user = request()->user();
        if ( $user ) {
            $category = Category::where('user_id', $user->id)
                ->where('id', $category_id)
                ->firstOrFail();

            if ( $category ) {
                $task = $category
                    ->tasks()
                    ->where('id',$task_id)
                    ->firstOrFail();

                if ( $task ) {
                    $task->delete();
                    $response = array("text" => ["message" => "Task deleted successful"], "status" => 201);
                } else {
                    $response = array("message" => "Task doesn't found");
                }
            } else {
                $response = array("text" => ["message" => "Category doesn't found"], "status" => 404);
            }
        } else {
            $response = array("text" => ["message" => "User doesn't exist"], "status" => 404);
        }

        return $response;
    }
}