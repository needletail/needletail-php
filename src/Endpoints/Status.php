<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Status extends BaseEndpoint
{

    /**
     * Alternatives constructor.
     *
     * @param  string  $apiKey
     * @param  Bucket  $bucket
     */
    public function __construct(string $apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * @return int
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function check(): int
    {
        $response = $this->get();

        return $response->getStatusCode();
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "status";
    }
}
