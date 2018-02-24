<?php

interface TransformerInterface
{
	public function transform($object_model);
	public function collection($objects_model);
	public function item($object_model);
}