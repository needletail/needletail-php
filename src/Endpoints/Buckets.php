<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Buckets extends BaseEndpoint
{

    /**
     * @return array
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function all(): array
    {
        $response = $this->get();
        $data = $this->toObject($response)->data;

        $buckets = [];
        foreach ($data as $item) {
            $buckets[] = $this->toEntity($item);
        }

        return $buckets;
    }

    /**
     * @param  object  $item
     * @return Bucket
     */
    protected function toEntity(object $item): Bucket
    {
        return (new Bucket())
            ->setApiKey($this->apiKey)
            ->setName($item->name)
            ->setShowScore($item->show_score)
            ->setDocumentCount($item->document_count)
            ->setSearchableAttributes($item->searchable_attributes)
            ->setRetrievableAttributes($item->retrievable_attributes)
            ->setGroupBy($item->group_by)
            ->setAttributes($item->attributes ?? null)
            ->setBoosts($item->boosts ?? null);
    }

    /**
     * @param  Bucket  $bucket
     * @return Bucket
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(Bucket $bucket): Bucket
    {
        $response = $this->post($bucket->toArray());
        $data = $this->toObject($response);

        return $this->toEntity($data);
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
     * @return Bucket
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function find(string $id): Bucket
    {
        $response = $this->get($id);
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @param  string  $id
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function truncate(string $id): string
    {
        $response = $this->post("{$id}/truncate");
        $data = $this->toObject($response);

        return $data->message;
    }

    /**
     * @param  Bucket  $bucket
     * @return Bucket
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function update(Bucket $bucket): Bucket
    {
        $response = $this->put($bucket->getName(), $bucket->toArray());
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'buckets';
    }

}