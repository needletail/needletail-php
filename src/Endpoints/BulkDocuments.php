<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Entities\Document;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class BulkDocuments extends BaseEndpoint
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * BulkDocuments constructor.
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
     * @param  array  $documents
     * @return array
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(array $documents): array
    {
        $response = $this->post($documents);
        $data = $this->toObject($response)->data;

        $createdDocuments = [];
        foreach ($data as $item) {
            $createdDocuments[] = $this->toEntity($item);
        }

        return $createdDocuments;
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
     * @param  array  $ids
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(array $ids): string
    {
        $response = $this->delete(
            null,
            [
                'json' => $ids,
            ]
        );
        $data = $this->toObject($response);

        return $data->message;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "buckets/{$this->bucket->getName()}/documents/bulk";
    }
}