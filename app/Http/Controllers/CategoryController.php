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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
