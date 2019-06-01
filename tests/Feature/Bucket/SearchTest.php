<?php

namespace Tests\Feature\Search;

use Tests\TestCase;
use Needletail\Client;

class SearchTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var \Needletail\Bucket
     */
    private $bucket;

    protected function setUp()
    {
        parent::setUp();

        $this->client = new Client(
            $this->read_key,
            $this->write_key
        );

        $this->bucket = $this->client->initBucket('vacancies');
        $this->bucket->createBucket();
    }

    /** @test */
    public function testListAllBuckets()
    {
        $response = $this->client->list();

        $this->assertGreaterThan(0, $response->count());
    }

    /** @test */
    public function testSearch()
    {
        $this->assertInstanceOf(\Needletail\Bucket::class, $this->bucket);

        $response = $this->bucket->search([
            'settings' => [
                'size' => 1
            ]
        ]);

        $this->assertInstanceOf(\Needletail\NeedletailResult::class, $response);

        $this->assertArrayHasKey('time', $response);
    }
}
