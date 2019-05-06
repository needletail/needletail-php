<?php

namespace Tests\Unit;

use Tests\TestCase;
use Needletail\Client;

class NeedletailResultTest extends TestCase
{
    /**
     * @var \Needletail\NeedletailResult
     */
    private $response;

    protected function setUp()
    {
        parent::setUp();

        $client = new Client(
            $this->read_key,
            $this->write_key
        );

        $this->response = $client->initBucket('vacancies')->search([
            'settings' => [
                'size' => 1
            ]
        ]);
    }

    /** @test */
    public function testToArray()
    {
        $this->assertInternalType(
            'array',
            $this->response->toArray()
        );

        $this->assertArrayHasKey(
            'time',
            $this->response->toArray()
        );
    }

    /** @test */
    public function testToCollection()
    {
        $this->assertInstanceOf(
            \Tightenco\Collect\Support\Collection::class,
            $this->response->toCollection()
        );

        $this->assertInternalType(
            'int',
            $this->response->toCollection()->get('time')
        );
    }

    /** @test */
    public function testIsItteratable()
    {
        foreach ($this->response as $key => $item) {
            $this->assertTrue(in_array($key, ['time', 'data', 'total', 'max_search_score']));
        }
    }
}
