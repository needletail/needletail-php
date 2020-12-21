<?php

namespace Needletail\Helpers;

class BaseEntity
{

    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey): BaseEntity
    {
        $this->apiKey = $apiKey;
        return $this;
    }
}