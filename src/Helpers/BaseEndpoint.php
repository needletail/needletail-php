<?php

namespace Needletail\Helpers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Needletail\Exceptions\NeedletailException;
use Psr\Http\Message\ResponseInterface;

use function array_merge;
use function json_decode;

abstract class BaseEndpoint
{
    /**
     * @var string
     */
    protected string $apiKey;
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * BaseEndpoint constructor.
     *
     * @param  string  $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client(
            [
                'base_uri'    => ConfigHelper::get('base_uri'),
                // Guzzle 7
                'http_errors' => false,
                // Guzzle 6
                'exception'   => false,
                'verify' => false,
            ]
        );
    }

    /**
     * @param  string|null  $id
     * @param  array        $options
     * @return ResponseInterface
     * @throws NeedletailException
     * @throws GuzzleException
     */
    protected function delete(string $id = null, array $options = []): ResponseInterface
    {
        $endpoint = $this->parseEndpoint($id);

        try {
            $response = $this->client->delete(
                $endpoint,
                [
                    'headers' => $this->buildHeaders($options),
                    'json'    => ($options['json']) ?? null,
                ]
            );

            return $this->handleResponse($response);
        } catch (Exception $e) {
            // Rethrow the exception for easier finding which package throws it.
            throw new NeedletailException($e->getMessage());
        }
    }

    /**
     * @param  string|null  $id
     * @return string
     */
    protected function parseEndpoint(?string $id): string
    {
        $endpoint = $this->getEndpoint();
        return $endpoint.((!empty($id)) ? "/$id" : "");
    }

    /**
     * @return string
     */
    abstract protected function getEndpoint(): string;

    /**
     * @param  array  $options
     * @return array
     */
    private function buildHeaders(array $options = []): array
    {
        return array_merge(
            [
                'x-needletail-api-key' => $this->apiKey,
            ],
            ($options['headers']) ?? []
        );
    }

    /**
     * @param  ResponseInterface  $response
     * @return ResponseInterface
     * @throws NeedletailException
     */
    private function handleResponse(ResponseInterface $response): ResponseInterface
    {
        if ($this->successful((int)$response->getStatusCode())) {
            return $response;
        }

        $body = $this->toObject($response);
        throw new NeedletailException(
            "{$response->getStatusCode()}: {$response->getReasonPhrase()} ".((!empty($body->message)) ? "({$body->message})" : '')
        );
    }

    /**
     * @param  int  $status
     * @return bool
     */
    private function successful(int $status): bool
    {
        return $status >= 200 && $status < 300;
    }

    /**
     * @param  ResponseInterface  $response
     * @return object|null
     */
    protected function toObject(ResponseInterface $response): ?object
    {
        return json_decode($response->getBody(), false);
    }

    /**
     * @param  string|null  $id
     * @param  array        $options
     * @return ResponseInterface
     * @throws NeedletailException
     * @throws GuzzleException
     */
    protected function get(?string $id = null, array $options = []): ResponseInterface
    {
        $endpoint = $this->parseEndpoint($id);

        try {
            $response = $this->client->get(
                $endpoint,
                [
                    'headers' => $this->buildHeaders($options),
                    'json'    => ($options['json']) ?? null,
                ]
            );

            return $this->handleResponse($response);
        } catch (Exception $e) {
            // Rethrow the exception for easier finding which package throws it.
            throw new NeedletailException($e->getMessage());
        }
    }

    /**
     * @param  string|null  $id
     * @param  array        $data
     * @param  array        $options
     * @return ResponseInterface
     * @throws NeedletailException
     * @throws GuzzleException
     */
    protected function post(?string $id = null, array $data = [], array $options = []): ResponseInterface
    {
        $endpoint = $this->parseEndpoint($id);

        try {
            $response = $this->client->post(
                $endpoint,
                [
                    'headers' => $this->buildHeaders($options),
                    'json'    => $data,
                ]
            );

            return $this->handleResponse($response);
        } catch (ClientException $e) {
            // Rethrow the exception for easier finding which package throws it.
            throw new NeedletailException($e->getMessage());
        }
    }

    /**
     * @param  string|null  $id
     * @param  array        $data
     * @param  array        $options
     * @return ResponseInterface
     * @throws NeedletailException
     * @throws GuzzleException
     */
    protected function put(string $id = null, array $data = [], array $options = []): ResponseInterface
    {
        $endpoint = $this->parseEndpoint($id);

        try {
            $response = $this->client->put(
                $endpoint,
                [
                    'headers' => $this->buildHeaders($options),
                    'json'    => $data,
                ]
            );

            return $this->handleResponse($response);
        } catch (Exception $e) {
            // Rethrow the exception for easier finding which package throws it.
            throw new NeedletailException($e->getMessage());
        }
    }
}