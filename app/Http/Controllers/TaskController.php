<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;

class TaskController extends ContentNegotiationController
{
    private $task;
    private $transformer;

    public function __construct(TaskRepository $task, TaskTransformer $transformer)
    {
        $this->task = $task;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $category_id
     * @return \Illuminate\Http\Response
     */
    public function index($category_id)
    {
	    list($response_array, $status_code) = $this->task->getAllByCategoryAndUser($category_id);
	    return $this->responseWith($response_array, $status_code);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param $category_id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function store(Request $request, $category_id)
    {
	    list($response_array, $status_code) = $this->task->createByCategoryAndUser($request->all(), $category_id);
	    return $this->responseWith($response_array, $status_code);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $category_id
	 * @param $task_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function show($category_id, $task_id)
    {
	    list($response_array, $status_code) = $this->task->showByUserTaskIDAndCategoryID($category_id, $task_id);
	    return $this->responseWith($response_array, $status_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $category_id
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id, $task_id)
    {
	    list($response_array, $status_code) = $this->task->updateByUserTaskIDandCategoryID($request->all(), $category_id, $task_id);
	    return $this->responseWith($response_array, $status_code);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $category_id
	 *
	 * @param $task_id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function destroy($category_id, $task_id)
    {
	    list($response_array, $status_code) = $this->task->deleteByUserTaskIDandCategoryID($category_id, $task_id);
	    return $this->responseWith($response_array, $status_code);
    }
}
