<?php

namespace Needletail\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Entities\Synonym;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

class Synonyms extends BaseEndpoint
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * Synonyms constructor.
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
     * @return Synonym
     */
    protected function toEntity(object $item): Synonym
    {
        return (new Synonym())
            ->setApiKey($this->apiKey)
            ->setBucket($this->bucket)
            ->setId($item->id)
            ->setWords($item->words);
    }

    /**
     * @param  Synonym  $synonym
     * @return Synonym
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(Synonym $synonym): Synonym
    {
        $response = $this->post(null, $synonym->toArray());
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @param  string  $id
     * @return Synonym
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(string $id): Synonym
    {
        $response = $this->delete($id);
        $data = $this->toObject($response);

        return $data->message;
    }

    /**
     * @param  string  $id
     * @return Synonym
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function find(string $id): Synonym
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
        return "buckets/{$this->bucket->getName()}/synonyms";
    }
}