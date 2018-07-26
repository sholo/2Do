<?php

namespace App\Http\Controllers;

use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PrepareResponse
{
	const CODE_WRONG_ARGS = 'GEN-FUBARGS';
    const CODE_NOT_FOUND = 'GEN-LIKETHEWIND';
    const CODE_INTERNAL_ERROR = 'GEN-AAAGGH';
    const CODE_UNAUTHORIZED = 'GEN-MAYBGTFO';
    const CODE_FORBIDDEN = 'GEN-GTFO';
    const CODE_INVALID_MIME_TYPE = 'GEN-IVMITYP';

	protected $statusCode = 200;

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param $statusCode
	 *
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * @param Model $item
	 * @param Transformer $callback
	 *
	 * @return array
	 */
	public function respondWithItem(Model $item, Transformer $callback)
	{
		$resource = $callback->item($item);
		return $this->respondWithArray(array('data' => $resource));
	}

	/**
	 * @param string $model_type
	 * @param string $message
	 *
	 * @return array
	 */
	public function respondWithoutItem($model_type = "", $message = "The element of this MODEL type was successfully deleted")
	{
		if ( $model_type !== "" ) {
			$message = str_replace("MODEL", $model_type, $message);
		}

		return $this->respondWithArray([
			'data' => [
				'http_code' => $this->statusCode,
				'message' => $message,
			]
		]);
	}

	/**
	 * @param LengthAwarePaginator $collection
	 * @param Transformer $callback
	 *
	 * @return array
	 */
	public function respondWithCollection(LengthAwarePaginator $collection, Transformer $callback)
	{
		$resource = $callback->collection($collection);
		return $this->respondWithArray([
			'data' => $resource,
			'pagination' => [
				'total_count' => $collection->total(),
				'total_pages' => ceil($collection->total() / $collection ->perPage()),
				'current_page' => $collection->currentPage(),
				'limit' => (int) $collection->perPage(),
				'previous_page' => $collection->previousPageUrl() ? : (bool) $collection->previousPageUrl(),
				'next_page' => $collection->nextPageUrl() ? : (bool) $collection->nextPageUrl(),
			]
		]);
	}

	/**
	 * @param array $array
	 *
	 * @return array
	 */
	protected function respondWithArray(array $array)
	{
		return [$array, $this->statusCode];
	}

	/** ---------ERROR SECTION--------- **/

	/**
	 *
	 * @param $message
	 * @param $errorCode
	 *
	 * @return array
	 */
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
	 * @param string $message
	 *
	 * @return array
	 */
	public function errorForbidden($message = 'Forbidden')
	{
	    return $this->setStatusCode(403)
	                ->respondWithError($message, self::CODE_FORBIDDEN);
	}

	/**
	 * Generates a Response with a 500 HTTP header and a given message.
	 *
	 * @param string $message
	 *
	 * @return array
	 */
	public function errorInternalError($message = 'Internal Error')
	{
		return $this->setStatusCode(500)
		            ->respondWithError($message, self::CODE_INTERNAL_ERROR);
	}

	/**
	 * Generates a Response with a 404 HTTP header and a given message.
	 *
	 * @param string $message
	 *
	 * @return array
	 */
	public function errorNotFound($message = 'Resource Not Found')
	{
	    return $this->setStatusCode(404)
	                ->respondWithError($message, self::CODE_NOT_FOUND);
	}

	/**
	 * Generates a Response with a 401 HTTP header and a given message.
	 *
	 * @param string $message
	 *
	 * @return array
	 */
	public function errorUnauthorized($message = 'Unauthorized')
	{
	    return $this->setStatusCode(401)
	                ->respondWithError($message, self::CODE_UNAUTHORIZED);
	}

	/**
	 * Generates a Response with a 400 HTTP header and a given message.
	 *
	 * @param string $message
	 *
	 * @return array
	 */
	public function errorWrongArgs($message = 'Wrong Arguments')
	{
	    return $this->setStatusCode(400)
	                ->respondWithError($message, self::CODE_WRONG_ARGS);
	}
}