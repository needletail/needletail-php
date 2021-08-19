<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Entities\Document;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Documents extends BaseEndpoint
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
     * @param  array  $document
     * @return Document
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(array $document): Document
    {
        $response = $this->post(null, $document);
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @param  object  $item
     * @return Document
     */
    protected function toEntity(object $item): Document
    {
        return (new Document())
            ->setApiKey($this->apiKey)
            ->setBucket($this->bucket)
            ->setId($item->document_id);
    }

    /**
     * @param  string  $id
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(string $id): string
    {
        $response = $this->delete($id);
        $data = $this->toObject($response);

        return $data->message;
    }

    /**
     * @param  string  $id
     * @param  array  $document
     * @return Document
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function update(string $id, array $document): Document
    {
        $response = $this->put($id, $document);
        $data = $this->toObject($response)->data;

        return $this->toEntity($data);
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "buckets/{$this->bucket->getName()}/documents";
    }
}
