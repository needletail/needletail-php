<?php

namespace Needletail\Http;

use Needletail\Bucket;
use GuzzleHttp\Client;
use Needletail\NeedletailResult;
use GuzzleHttp\Exception\ClientException;

class Query
{
    /**
     * Call the Needletail API based on the given path and bucket params.
     *
     * @param  string $path
     * @param  Bucket $bucket
     * @param  string $api_key
     * @param  string $method
     * @param  array $headers
     * @return NeedletailResult
     */
    public static function execute(string $path, Bucket $bucket, string $api_key, string $method = 'post', array $headers = [])
    {
        $headers = array_merge($headers, [
            'x-needletail-bucket' => $bucket->getName()
        ]);

        return static::raw(
            $path, $method, $api_key, $bucket->getParams(), $headers
        );
    }

    /**
     * Run a 'raw' query against the Needletail API.
     *
     * @param  string $path
     * @param  string $method
     * @param  string|null $api_key
     * @param  array $data
     * @param  array $headers
     * @return NeedletailResult
     */
    public static function raw(string $path, string $method, ?string $api_key, array $data = [], array $headers = [])
    {
        $client = new Client(['base_uri' => 'https://api.staging.needletail.io/2.0/']);

        $predefined_headers = [
            'x-needletail-api-key' => $api_key
        ];

        try {
            $response = $client->{$method}($path, [
                'json' => $data,
                'headers' => array_merge($predefined_headers, $headers),
                'allow_redirects' => false
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return new NeedletailResult(
            json_decode($response->getBody()->getContents(), true) ?: []
        );
    }
}
