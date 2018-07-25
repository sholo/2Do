<?php
namespace App\Repositories;

use App\Http\Controllers\PrepareResponse;

abstract class AbstractRepository
{

    protected $prepare_response;

    /**
     * Repository constructor.
     * @param PrepareResponse $prepareResponse
     */
	public function __construct(PrepareResponse $prepareResponse)
    {
        $this->prepare_response = $prepareResponse;
    }
}