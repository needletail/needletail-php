<?php

namespace Needletail;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Buckets;
use Needletail\Endpoints\Search;
use Needletail\Entities\Bucket;
use Needletail\Helpers\ClientDocuments;
use Needletail\Helpers\DeprecationHelper;

class Client
{

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * Client constructor.
     *
     * @param  string  $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param  array  $params
     * @return object
     * @throws Exceptions\NeedletailException
     * @throws GuzzleException
     */
    public function bulk(array $params)
    {
        $search = new Search($this->apiKey);
        return $search->find($params);
    }

    /**
     * @param  string  $bucket
     * @return Entities\Bucket
     * @throws Exceptions\NeedletailException
     * @throws GuzzleException
     */
    public function initBucket(string $bucket)
    {
        DeprecationHelper::trigger(__METHOD__, 'buckets()->create($bucket)');
        return $this->buckets()->create($bucket);
    }

    /**
     * @return Buckets
     */
    public function buckets()
    {
        return new Buckets($this->apiKey);
    }

    public function documents()
    {
        return new ClientDocuments($this->apiKey);
    }

    public function synonyms($bucketName)
    {
        $bucket = new Bucket();
        return $bucket->setApiKey($this->apiKey)
            ->setName($bucketName)
            ->synonyms();
    }

    public function alternatives($bucketName)
    {
        $bucket = new Bucket();
        return $bucket->setApiKey($this->apiKey)
            ->setName($bucketName)
            ->alternatives();
    }

    /**
     * @param  array  $params
     * @return object
     * @throws Exceptions\NeedletailException
     * @throws GuzzleException
     */
    public function search(array $params)
    {
        $search = new Search($this->apiKey);
        return $search->find($params);
    }
}
