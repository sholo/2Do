<?php

namespace App\Http\Controllers;

use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
	const CODE_WRONG_ARGS = 'GEN-FUBARGS';
    const CODE_NOT_FOUND = 'GEN-LIKETHEWIND';
    const CODE_INTERNAL_ERROR = 'GEN-AAAGGH';
    const CODE_UNAUTHORIZED = 'GEN-MAYBGTFO';
    const CODE_FORBIDDEN = 'GEN-GTFO';

	protected $statusCode = 200;
	private $hateoas;

	public function __construct()
	{
		$this->hateoas = new Hateoas();
	}

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	protected function respondWithItem(Model $item, Transformer $callback)
	{
		$resource = $callback->item($item);
		$rootScope = $this->hateoas->createData($resource);

		return $this->respondWithArray($rootScope);
	}

	protected function respondWithCollection($collection, Transformer $callback)
	{
		$resource = $callback->collection($collection);
		$rootScope = $this->hateoas->createData($resource);

		return $this->respondWithArray($rootScope);
	}

	protected function respondWithArray(array $array, array $headers = [])
	{
		return response()->json($array, $this->statusCode, $headers);
	}

	/** ---------ERROR SECTION--------- **/


	protected function respondWithError($message, $errorCode)
	{
		if ($this->statusCode === 200) {
			trigger_error(
				"You better have a really good reason for erroring on a 200...",
				E_USER_WARNING
			);
		}

		return $this->respondWithArray([
			'error' => [
				'code' => $errorCode,
				'http_code' => $this->statusCode,
				'message' => $message,
			]
		]);
	}

	/**
	* Generates a Response with a 403 HTTP header and a given message.
	*
	* @return Response
	*/
	public function errorForbidden($message = 'Forbidden')
	{
	    return $this->setStatusCode(403)
	                ->respondWithError($message, self::CODE_FORBIDDEN);
	}

	/**
	* Generates a Response with a 500 HTTP header and a given message.
	*
	* @return Response
	*/
	public function errorInternalError($message = 'Internal Error')
	{
		return $this->setStatusCode(500)
		            ->respondWithError($message, self::CODE_INTERNAL_ERROR);
	}

	/**
	* Generates a Response with a 404 HTTP header and a given message.
	*
	* @return Response
	*/
	public function errorNotFound($message = 'Resource Not Found')
	{
	    return $this->setStatusCode(404)
	                ->respondWithError($message, self::CODE_NOT_FOUND);
	}

	/**
	* Generates a Response with a 401 HTTP header and a given message.
	*
	* @return Response
	*/
	public function errorUnauthorized($message = 'Unauthorized')
	{
	    return $this->setStatusCode(401)
	                ->respondWithError($message, self::CODE_UNAUTHORIZED);
	}

	/**
	* Generates a Response with a 400 HTTP header and a given message.
	*
	* @return Response
	*/
	public function errorWrongArgs($message = 'Wrong Arguments')
	{
	    return $this->setStatusCode(400)
	                ->respondWithError($message, self::CODE_WRONG_ARGS);
	}
}