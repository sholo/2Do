<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
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
	    list($response_array, $status_code) = $this->repository->createByUser($request->all());
	    return $this->responseWith($response_array, $status_code);
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
	    list($response_array, $status_code) = $this->repository->showCategoryOfUser($id);
	    return $this->responseWith($response_array, $status_code);
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
	    list($response_array, $status_code) = $this->repository->updateByUser($request->all(), $id);
	    return $this->responseWith($response_array, $status_code);
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
	    list($response_array, $status_code) = $this->repository->deleteByUser($id);
	    return $this->responseWith($response_array, $status_code);
    }
}
