<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Search extends BaseEndpoint
{

    /**
     * @param  array  $params
     * @return object
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function find(array $params): object
    {
        $response = $this->post(
            null,
            null,
            [
                'json' => $params,
            ]
        );

        return $this->toObject($response)->data;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "search";
    }
}