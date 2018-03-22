<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\TaskRepository;
use App\Transformers\TaskTransformer;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
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
        $resource = $this->task->getAllByCategoryAndUser($category_id);
        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $category_id)
    {
        $response = $this->task->createByCategoryAndUser($request->all(), $category_id);
        return response()->json($response['text'], $response['status']);
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
	    $resource = $this->task->showByUserTaskIDAndCategoryID($category_id, $task_id);
	    return response()->json($resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
