<?php

namespace App\Transformers;

use App\Http\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;

class CategoryTransformer extends Transformer
{
	/**
	 * Transform a category model.
	 *
	 * @param Model $category
	 *
	 * @return array
	 */
	protected function transform(Model $category)
	{
		return [
			'id' => (int) $category->id,
			'category' => $category->name,
		];
	}
}