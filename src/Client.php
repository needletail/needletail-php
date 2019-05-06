<?php

namespace Needletail;

use Needletail\Http\Query;

class Client
{
    /**
     * An API key asscociated with all the read functionalities.
     *
     * @var string
     */
    private $read_key;

    /**
     * An API key asscociated with all the write functionalities.
     *
     * @var string
     */
    private $write_key;

    /**
     * Create a new Needletail client.
     *
     * @param  string $read_key
     * @param  string $write_key
     * @return void
     */
    public function __construct(string $read_key, string $write_key)
    {
        $this->read_key = $read_key;

        $this->write_key = $write_key;
    }

    /**
     * Intialize a new bucket. If the given bucket does not exist, the bucket will be automatically created.
     *
     * @param  string $bucket
     * @return Bucket
     */
    public function initBucket(string $bucket)
    {
        $bucket = new Bucket(
            $bucket,
            $this->read_key,
            $this->write_key
        );

        if (!$bucket->exists()) {
            $bucket->createBucket();
        }

        return $bucket;
    }

    /**
     * List all buckets available to the given key.
     *
     * @return NeedletailResult
     */
    public function list()
    {
        return Query::raw('buckets', 'get', $this->read_key);
    }

    /**
     * Generate a private key with the given parameters.
     *
     * @param  array $params
     * @return NeedletailResult
     */
    public function createPrivateKey(array $params)
    {
        return Query::raw('private', 'post', $this->write_key, $params);
    }

    /**
     * Perform a batch query on the Needletail API.
     *
     * @param  array $params
     * @return NeedletailResult
     */
    public function batch(array $params)
    {
        $batch = [
            'read_key' => $this->read_key,
            'write_key' => $this->write_key,
            'requests' => [
                $params
            ]
        ];

        return Query::raw('batch', 'post', null, $batch);
    }
}
