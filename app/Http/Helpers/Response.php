<?php

namespace App\Http\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class Response
{
    public static function response($body = null, $status = true, $statusCode = 200)
    {
        return response()->json([
            "status" => $status,
            "data" => $body,
        ], $statusCode);
    }

    public static function get(Request $request, $domen, $headers = null, $query = null)
    {
        try {
            $client = new Client();
            $url = $domen . self::getUrlPath($request);
            $response = $client->get($url, [
                'headers' => $headers ?? [],
                'query' => $query ?? [],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $clientRequest = $e->getRequest();
            $bodyError = json_decode($response->getBody());
            if (
                isset($bodyError->message) &&
                isset($bodyError->line) &&
                $clientRequest->getUri()
            ) {
                $body = [
                    "message" => $bodyError->message,
                    "line" => $bodyError->line,
                    "route" => $request->path(),
                ];
            } else {
                $body = [
                    "message" => "Ошибка при вызове AgentService",
                    "route" => $request->path(),
                ];
            }

            return self::response($body, false, $response->getStatusCode());
        }
    }

    public static function getUrlPath(Request $request)
    {
        return $request->path();
    }
}
