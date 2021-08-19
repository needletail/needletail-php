<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Mapping extends BaseEndpoint
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * Documents constructor.
     *
     * @param  string  $apiKey
     * @param  Bucket  $bucket
     */
    public function __construct(string $apiKey, Bucket $bucket)
    {
        parent::__construct($apiKey);

        $this->bucket = $bucket;
    }

    /**
     * @param  array  $mapping
     * @param  boolean  $ignoreErrors
     * @return object
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(array $mapping, $ignoreErrors = false): object
    {
        $response = $this->post(null, [
            'mapping'       => $mapping,
            'ignore_errors' => $ignoreErrors,
        ]);

        return $this->toObject($response);
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "buckets/{$this->bucket->getName()}/mapping";
    }
}
