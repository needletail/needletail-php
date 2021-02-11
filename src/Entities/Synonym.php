<?php

namespace Needletail\Entities;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Synonyms;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEntity;

class Synonym extends BaseEntity
{

    /**
     * @var Bucket
     */
    private Bucket $bucket;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var array
     */
    private array $words;

    public function __construct($words = null, $apiKey = null)
    {
        if (!\is_null($words)) {
            $this->setWords($words);
        }

        if (!\is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * @return Synonym
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(): Synonym
    {
        return $this->endpoint()->create($this);
    }

    /**
     * @return Synonyms
     */
    private function endpoint(): Synonyms
    {
        return new Synonyms($this->apiKey, $this->bucket);
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function destroy(): string
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
     * @return Synonym
     */
    public function setId(string $id): Synonym
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param  Bucket  $bucket
     * @return $this
     */
    public function setBucket(Bucket $bucket): Synonym
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
            'words' => $this->getWords(),
        ];
    }

    /**
     * @return array
     */
    public function getWords(): array
    {
        return $this->words;
    }

    /**
     * @param  array  $words
     * @return Synonym
     */
    public function setWords(array $words): Synonym
    {
        $this->words = $words;
        return $this;
    }
}
