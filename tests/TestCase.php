<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * The API key associated with all read operations.
     *
     * @var string
     */
    protected $read_key = '';

    /**
     * The API key associated with all write operations.
     *
     * @var string
     */
    protected $write_key = '';

    protected function setUp()
    {
        parent::setUp();
    }
}
