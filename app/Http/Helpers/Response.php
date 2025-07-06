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
        $client = new Client();
        $url = $domen . self::getUrlPath($request);
        $response = $client->get($url, [
            'headers' => $headers ?? [],
            'query' => $query ?? [],
        ]);

        return json_decode($response->getBody(), true);
    }

    public static function getUrlPath(Request $request)
    {
        return $request->path();
    }
}
