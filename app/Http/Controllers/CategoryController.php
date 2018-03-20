<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $resource = $this->category->getAllByUser();
        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->category->createByUser($request->all());
	    return response()->json($response['text'], $response['status']);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function show($id)
    {
        $category = $this->category->showByUserAndCategoryID($id);
        return response()->json($category);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function update(Request $request, $id)
    {
        $response = $this->category->updateByUser($request->all(), $id);
	    return response()->json($response);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
    public function destroy($id)
    {
	    $response = $this->category->deleteByUser($id);
	    return response()->json($response['text'], $response['status']);
    }
}
