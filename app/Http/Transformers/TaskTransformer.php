<?php

namespace App\Http\Transformers;

class TaskTransformer implements TransformerInterface
{
	/**
	 * Transform a task model.
	 *
	 * @param  \App\Task $task
	 * @return array
	 */
	public function transform($task)
	{
		return [
			'id' => (int) $task->id,
			'task' => $task->description,
		];
	}

	/**
	 * Transform a collection of tasks.
	 *
	 * @param  \Illuminate\Database\Eloquent\Collection $tasks
	 * @return array
	 */
	public function collection($tasks)
	{
		$resource = [];

		foreach ($tasks as $task) {
			$resource[] = $this->transform($task);
		}

		return $resource;
	}

	/**
	 * Transform a single task model.
	 *
	 * @param  \App\Task $task
	 * @return array
	 */
	public function item($task)
	{
		return $this->transform($task);
	}
}