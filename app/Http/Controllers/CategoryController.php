<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryController extends ContentNegotiationController
{
    private $repository;

	/**
	 * CategoryController constructor.
	 */
	public function __construct()
    {
	    $this->repository = new CategoryRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        list($response_array, $status_code) = $this->repository->getAllOfUser();
        return $this->responseWith($response_array, $status_code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function store(Request $request)
    {
        $category = $this->repository->createByUser($request->all());
	    if (! $category instanceof Model) {
		    return $this->errorWrongArgs();
	    }

	    return $this->respondWithItem($category, new CategoryTransformer);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Support\Facades\Response
	 */
    public function show($id)
    {
        $category = $this->repository->showCategoryOfUser($id);
	    if (! $category instanceof Model) {
		    return $this->errorNotFound();
	    }

	    return $this->respondWithItem($category, new CategoryTransformer);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Support\Facades\Response
	 */
    public function update(Request $request, $id)
    {
	    $category = $this->repository->updateByUser($request->all(), $id);
	    if (! $category instanceof Model) {
		    return $this->errorWrongArgs();
	    }
	    return $this->respondWithItem($category, new CategoryTransformer);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Support\Facades\Response
	 * @throws \Exception
	 */
    public function destroy($id)
    {
	    $category = $this->repository->deleteByUser($id);
	    if (! $category instanceof Model) {
		    return $this->errorNotFound();
	    }
	    return $this->respondWithItem($category, new CategoryTransformer);
    }
}
