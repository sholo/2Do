<?php

namespace App\Transformers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

abstract class Transformer
{
	/**
	 * @param Model $object_model
	 *
	 * @return array
	 */
	abstract protected function transform(Model $object_model);

	/**
	 * Transform a collection of elements.
	 *
	 * @param Paginator $paginator
	 *
	 * @return array
	 */
	public function collection(Paginator $paginator)
	{
		$resource = [];

		foreach ($paginator as $object_model) {
			$resource[] = $this->transform($object_model);
		}

		return $resource;
	}

	/**
	 * Transform a single element model.
	 *
	 * @param Model $object_model
	 *
	 * @return array
	 */
	public function item(Model $object_model)
	{
		return $this->transform($object_model);
	}

	/**
	 * @param Model $object_model
	 *
	 * @return array
	 */
	public function modelToArray(Model $object_model)
	{
		return $object_model->toArray();
	}
}