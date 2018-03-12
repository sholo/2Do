<?php

namespace App\Transformers;

use App\Http\Transformers\TransformerInterface;

class CategoryTransformer implements TransformerInterface
{
	/**
	 * Transform a category model.
	 *
	 * @param  \App\Category $category
	 * @return array
	 */
	public function transform($category)
	{
		return [
			'id' => (int) $category->id,
			'category' => $category->name,
		];
	}

	/**
	 * Transform a collection of categories.
	 *
	 * @param  \Illuminate\Database\Eloquent\Collection $categories
	 * @return array
	 */
	public function collection($categories)
	{
		$resource = [];

		foreach ($categories as $category) {
			$resource[] = $this->transform($category);
		}

		return $resource;
	}

	/**
	 * Transform a single category model.
	 *
	 * @param  \App\Category $category
	 * @return array
	 */
	public function item($category)
	{
		return $this->transform($category);
	}
}