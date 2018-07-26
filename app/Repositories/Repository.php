<?php
namespace App\Repositories;

use App\Http\Controllers\PrepareResponse;

abstract class AbstractRepository
{

    protected $prepare_response;
	const DEFAULT_LIMIT = 3;
	const MAXIMUM_LIMIT = 50;

    /**
     * Repository constructor.
     * @param PrepareResponse $prepareResponse
     */
	public function __construct(PrepareResponse $prepareResponse)
    {
        $this->prepare_response = $prepareResponse;
    }

	protected function checkUserExist()
	{
		return ( new \App\User )->find(1);

		$user = request()->user();
		if ( $user instanceof User ) {
			return $user;
		}
		return null;
	}
}