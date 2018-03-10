<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param CategoryTransformer $transformer
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index(CategoryTransformer $transformer)
    {
        $categories = Category::all();
        $resource = $transformer->collection($categories);
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
	    Category::create($request->all());
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
