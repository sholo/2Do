<?php
namespace App\Repositories;

use App\Http\Controllers\PrepareResponse;
use Illuminate\Support\Facades\Validator;

abstract class AbstractRepository
{
    protected $prepare_response;
    protected $validation_rules = array();

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

	protected function validateParameters(array $params)
	{
		if ( ! empty($this->getValidationRules()) ) {
			$validator = Validator::make($params, $this->getValidationRules());
			if ($validator->fails()) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return array
	 */
	public function getValidationRules() {
		return $this->validation_rules;
	}

	/**
	 * @param array $validation_rules
	 *
	 * @return AbstractRepository
	 */
	public function setValidationRules( array $validation_rules ) {
		$this->validation_rules = $validation_rules;
		return $this;
	}
}