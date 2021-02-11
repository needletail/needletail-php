<?php

namespace Needletail\Entities;

use GuzzleHttp\Exception\GuzzleException;
use Needletail\Endpoints\Alternatives;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEntity;

class Alternative extends BaseEntity
{

    /**
     * @var array
     */
    private array $alternative_words;
    /**
     * @var Bucket
     */
    private Bucket $bucket;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var string
     */
    private string $original_word;

    public function __construct($original_word = null, $alternative_words = null, $apiKey = null)
    {
        if (!\is_null($original_word)) {
            $this->setOriginalWord($original_word);
        }

        if (!\is_null($alternative_words)) {
            $this->setAlternativeWords($alternative_words);
        }

        if (!\is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * @return Alternative
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function create(): Alternative
    {
        return $this->endpoint()->create($this);
    }

    /**
     * @return Alternatives
     */
    private function endpoint(): Alternatives
    {
        return new Alternatives($this->apiKey, $this->bucket);
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
     * @return Alternative
     */
    public function setId(string $id): Alternative
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param  Bucket  $bucket
     * @return $this
     */
    public function setBucket(Bucket $bucket): Alternative
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'original_word'     => $this->getOriginalWord(),
            'alternative_words' => $this->getAlternativeWords(),
        ];
    }

    /**
     * @return string
     */
    public function getOriginalWord(): string
    {
        return $this->original_word;
    }

    /**
     * @param  string  $original_word
     * @return Alternative
     */
    public function setOriginalWord(string $original_word): Alternative
    {
        $this->original_word = $original_word;
        return $this;
    }

    /**
     * @return array
     */
    public function getAlternativeWords(): array
    {
        return $this->alternative_words;
    }

    /**
     * @param  array  $alternative_words
     * @return Alternative
     */
    public function setAlternativeWords(array $alternative_words): Alternative
    {
        $this->alternative_words = $alternative_words;
        return $this;
    }

}
