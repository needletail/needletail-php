<?php

namespace Needletail\Entities;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Documents;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEntity;

class Document extends BaseEntity
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var string
     */
    private string $id;

    /**
     * @return Document
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create()
    {
        return $this->endpoint()->create($this->getData());
    }

    /**
     * @return Documents
     */
    private function endpoint(): Documents
    {
        return new Documents($this->apiKey, $this->bucket);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param  array  $data
     * @return Document
     */
    public function setData(array $data): Document
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy()
    {
        return $this->endpoint()->destroy($this->getId());
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     * @return Document
     */
    public function setId(string $id): Document
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param  Bucket  $bucket
     * @return $this
     */
    public function setBucket(Bucket $bucket): Document
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * @return array[]
     */
    public function toArray()
    {
        return [
            'document' => $this->getData(),
        ];
    }

    /**
     * @return Document
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function update()
    {
        return $this->endpoint()->update($this->getId(), $this->getData());
    }
}
