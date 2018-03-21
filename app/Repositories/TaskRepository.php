<?php
namespace App\Repositories;

use App\Category;
use App\Task;
use App\Transformers\TaskTransformer;

class TaskRepository
{
    /**
     * @var $model
     */
    private $model;
    private $transformer;

    public function __construct(Task $model, TaskTransformer $transformer)
    {
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

    public function update($basemap_id, $new_map)
    {
        return DB::table('base_maps')
            ->where('id', $basemap_id)
            ->update(['map' => $new_map]);
    }
    public function delete($basemap_id)
    {
        return DB::table('base_maps')
            ->where('id', $basemap_id)
            ->delete();
    }
}