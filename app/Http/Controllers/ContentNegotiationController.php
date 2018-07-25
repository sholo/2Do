<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Yaml\Yaml;

class ContentNegotiationController extends Controller
{
	public function responseWith(array $array, $status_code = 200, array $headers = [])
	{
        $mimeParts = (array) explode(';', Input::server('HTTP_ACCEPT'));
        $mimeType = strtolower($mimeParts[0]);

        switch ($mimeType) {
            case 'application/json':
                $contentType = 'application/json';
                $content = json_encode($array);
                break;

            case 'application/x-yaml':
                $contentType = 'application/x-yaml';
                $content = Yaml::dump($array, 2);
                break;

            default:
                $contentType = 'application/json';
                $content = json_encode([
                     'error' => [
                         'code' => PrepareResponse::CODE_INVALID_MIME_TYPE,
                         'http_code' => 406,
                         'message' => sprintf('Content of type %s is not supported.', $mimeType),
                     ]
                ]);
        }

        $response = Response::make($content, $status_code, $headers);
        $response->header('Content-Type', $contentType);

        return $response;
	}
}