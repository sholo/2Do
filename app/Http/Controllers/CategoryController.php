<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\CategoryRepository;
use App\User;
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
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        $resource = $this->category->getAllByUser($user_id);
        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id, Request $request)
    {
	    Category::create($user_id, $request->all());
	    return response()->json(['message' => 'category_created'], 201);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param CategoryTransformer $transformer
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function show(CategoryTransformer $transformer, $id)
    {
        $category = Category::findOrFail($id);
        $resource = $transformer->item($category);
        return response()->json($resource);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CategoryTransformer $transformer
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function update(CategoryTransformer $transformer, Request $request, $id)
    {
	    $category = Category::find($id);
	    $category->fill($request->all())->save();
	    $resource = $transformer->item($category);
	    return response()->json($resource);
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
	    $category = Category::find($id);
	    $category->delete();
	    return response()->json(['message' => 'category_deleted'], 201);
    }
}
