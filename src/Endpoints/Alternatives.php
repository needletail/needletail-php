<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Alternative;
use Needletail\Entities\Bucket;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Alternatives extends BaseEndpoint
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * Alternatives constructor.
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
     * @return array
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function all(): array
    {
        $response = $this->get();
        $data = $this->toObject($response)->data;

        $synonyms = [];
        foreach ($data as $item) {
            $synonyms[] = $this->toEntity($item);
        }

        return $synonyms;
    }

    /**
     * @param  object  $item
     * @return Alternative
     */
    protected function toEntity(object $item): Alternative
    {
        return (new Alternative())
            ->setApiKey($this->apiKey)
            ->setBucket($this->bucket)
            ->setId($item->id)
            ->setOriginalWord($item->original_word)
            ->setAlternativeWords($item->alternative_words);
    }

    /**
     * @param  Alternative  $alternative
     * @return Alternative
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(Alternative $alternative): Alternative
    {
        $response = $this->post($alternative->toArray());
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @param  string  $id
     * @return Alternative
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(string $id): Alternative
    {
        $response = $this->delete($id);
        $data = $this->toObject($response);

        return $data->message;
    }

    /**
     * @param  string  $id
     * @return Alternative
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function find(string $id): Alternative
    {
        $response = $this->get($id);
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "buckets/{$this->bucket->getName()}/alternatives";
    }
}