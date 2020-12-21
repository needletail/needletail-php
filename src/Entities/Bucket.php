<?php

namespace Needletail\Entities;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Alternatives;
use Needletail\Endpoints\Buckets;
use Needletail\Endpoints\BulkDocuments;
use Needletail\Endpoints\Documents;
use Needletail\Endpoints\Synonyms;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEntity;

class Bucket extends BaseEntity
{

    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var bool
     */
    private bool $show_score = false;

    private int $document_count = 0;

    private ?array $searchable_attributes = null;

    private ?array $retrievable_attributes = null;

    private ?string $group_by = null;

    private ?array $attributes = [];

    private ?object $boosts = null;

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
     * @return string
     */
    public function getName(): string
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
            'name'       => $this->getName(),
            'show_score' => $this->isShowScore(),
            'document_count' => $this->getDocumentCount(),
            'searchable_attributes' => $this->getSearchableAttributes(),
            'retrievable_attributes' => $this->getRetrievableAttributes(),
            'group_by' => $this->getGroupBy(),
            'attributes' => $this->getAttributes(),
            'boosts' => $this->getBoosts(),
        ];
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

    /**
     * @return int
     */
    public function getDocumentCount(): int
    {
        return $this->document_count;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
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
     * @param  int  $document_count
     * @return Bucket
     */
    public function setDocumentCount(int $document_count): Bucket
    {
        $this->document_count = $document_count;
        return $this;
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
}