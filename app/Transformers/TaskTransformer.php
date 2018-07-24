<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;

class TaskTransformer extends Transformer
{
	/**
	 * Transform a task model.
	 *
	 * @param Model $task
	 *
	 * @return array
	 */
	protected function transform(Model $task)
	{
		$resource = $this->modelToArray($task);
		return [
			'id' => (int) $resource['id'],
			'task' => $resource['description'],
		];
	}
}