<?php

namespace App\Transformers;

use App\Http\Transformers\Transformer;
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
		return [
			'id' => (int) $task->id,
			'task' => $task->description,
		];
	}
}