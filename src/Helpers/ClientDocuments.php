<?php

namespace Needletail\Helpers;

use Needletail\Entities\Bucket;

class ClientDocuments
{

    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function bulk(string $bucketName)
    {
        $bucket = new Bucket();
        return $bucket->setApiKey($this->apiKey)
            ->setName($bucketName)
            ->bulkDocuments();
    }

    public function single(string $bucketName)
    {
        $bucket = new Bucket();
        return $bucket->setApiKey($this->apiKey)
            ->setName($bucketName)
            ->documents();
    }

}
