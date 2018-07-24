<?php

namespace App\Transformers;

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
		$resource = $this->modelToArray($category);
		return [
			'id' => (int) $resource['id'],
			'category' => $resource['name'],
			'_links' => [
				"tasks" => $resource['tasks_ids']
			]
		];
	}
}