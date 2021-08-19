<?php

namespace Needletail\Entities;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Alternatives;
use Needletail\Endpoints\Buckets;
use Needletail\Endpoints\BulkDocuments;
use Needletail\Endpoints\Documents;
use Needletail\Endpoints\Mapping;
use Needletail\Endpoints\Statistics;
use Needletail\Endpoints\Synonyms;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEntity;

use function is_null;

class Bucket extends BaseEntity
{

    private ?array $attributes = [];

    private ?object $boosts = null;

    private int $document_count = 0;

    private ?string $group_by = null;

    /**
     * @var string|null
     */
    private ?string $name = null;

    private ?array $retrievable_attributes = null;

    private ?array $searchable_attributes = null;

    /**
     * @var bool
     */
    private bool $show_score = false;

    public function __construct($name = null, $apiKey = null)
    {
        if (!is_null($name)) {
            $this->setName($name);
        }

        if (!is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * @return Alternatives
     * @throws NeedletailException
     */
    public function alternatives(): Alternatives
    {
        if (empty($this->apiKey)) {
            throw new NeedletailException('No API key is set.');
        }

        return new Alternatives($this->apiKey, $this);
    }

    /**
     * @return BulkDocuments
     */
    public function bulkDocuments(): BulkDocuments
    {
        return new BulkDocuments($this->apiKey, $this);
    }

    /**
     * @return Bucket
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(): Bucket
    {
        return $this->endpoint()->create($this);
    }

    /**
     * @return Buckets
     * @throws NeedletailException
     */
    private function endpoint(): Buckets
    {
        if (empty($this->apiKey)) {
            throw new NeedletailException('No API key is set.');
        }

        return new Buckets($this->apiKey);
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(): string
    {
        return $this->endpoint()->destroy($this->getName());
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  ?string  $name
     * @return Bucket
     */
    public function setName(?string $name): Bucket
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Documents
     * @throws NeedletailException
     */
    public function documents(): Documents
    {
        if (empty($this->apiKey)) {
            throw new NeedletailException('No API key is set.');
        }

        return new Documents($this->apiKey, $this);
    }

    /**
     * @return Mapping
     * @throws NeedletailException
     */
    public function mapping(): Mapping
    {
        if (empty($this->apiKey)) {
            throw new NeedletailException('No API key is set.');
        }

        return new Mapping($this->apiKey, $this);
    }

    /**
     * @return Statistics
     */
    public function statistics(): Statistics
    {
        return new Statistics($this->apiKey, $this);
    }

    /**
     * @return Synonyms
     * @throws NeedletailException
     */
    public function synonyms(): Synonyms
    {
        if (empty($this->apiKey)) {
            throw new NeedletailException('No API key is set.');
        }

        return new Synonyms($this->apiKey, $this);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'                   => $this->getName(),
            'show_score'             => $this->isShowScore(),
            'document_count'         => $this->getDocumentCount(),
            'searchable_attributes'  => $this->getSearchableAttributes(),
            'retrievable_attributes' => $this->getRetrievableAttributes(),
            'group_by'               => $this->getGroupBy(),
            'attributes'             => $this->getAttributes(),
            'boosts'                 => $this->getBoosts(),
        ];
    }

    /**
     * @return bool
     */
    public function isShowScore(): bool
    {
        return $this->show_score;
    }

    /**
     * @param  bool  $showScore
     * @return Bucket
     */
    public function setShowScore(bool $showScore): Bucket
    {
        $this->show_score = $showScore;
        return $this;
    }

    /**
     * @return int
     */
    public function getDocumentCount(): int
    {
        return $this->document_count;
    }

    /**
     * @param  ?int  $document_count
     * @return Bucket
     */
    public function setDocumentCount(?int $document_count): Bucket
    {
        if (is_null($document_count)) {
            $document_count = 0;
        }

        $this->document_count = $document_count;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getSearchableAttributes(): ?array
    {
        return $this->searchable_attributes;
    }

    /**
     * @param  array|null  $searchable_attributes
     * @return Bucket
     */
    public function setSearchableAttributes(?array $searchable_attributes): Bucket
    {
        $this->searchable_attributes = $searchable_attributes;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRetrievableAttributes(): ?array
    {
        return $this->retrievable_attributes;
    }

    /**
     * @param  array|null  $retrievable_attributes
     * @return Bucket
     */
    public function setRetrievableAttributes(?array $retrievable_attributes): Bucket
    {
        $this->retrievable_attributes = $retrievable_attributes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroupBy(): ?string
    {
        return $this->group_by;
    }

    /**
     * @param  string|null  $group_by
     * @return Bucket
     */
    public function setGroupBy(?string $group_by): Bucket
    {
        $this->group_by = $group_by;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param  null|array  $attributes
     * @return Bucket
     */
    public function setAttributes(?array $attributes): Bucket
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return object
     */
    public function getBoosts(): ?object
    {
        return $this->boosts;
    }

    /**
     * @param  null|object  $boosts
     * @return Bucket
     */
    public function setBoosts(?object $boosts): Bucket
    {
        $this->boosts = $boosts;
        return $this;
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function truncate(): string
    {
        return $this->endpoint()->truncate($this->getName());
    }

    /**
     * @return Bucket
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function update(): Bucket
    {
        return $this->endpoint()->update($this);
    }
}
