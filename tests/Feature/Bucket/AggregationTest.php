<?php

namespace Tests\Feature\Search;

use Needletail\NeedletailResult;
use Tests\TestCase;
use Needletail\Client;

class AggregationTest extends TestCase
{
    /**
     * @var \Needletail\Bucket
     */
    private $bucket;

    protected function setUp()
    {
        parent::setUp();

        $client = new Client(
            $this->read_key,
            $this->write_key
        );

        $this->bucket = $client->initBucket('testing-bucket');
        $this->bucket->createBucket();
    }

    /** @test */
    public function testAggregationWithoutFilters()
    {
        $response = $this->bucket->aggregation([
            'query' => [
                'title'
            ]
        ]);

        $this->assertInstanceOf(NeedletailResult::class, $response->data->title);
    }

    /** @test */
    public function testAggregationWithFiltersWithNoResults()
    {
        $response = $this->bucket->aggregation([
            'query' => [
                'title' => [
                    'description' => 'Lorem ipsum'
                ]
            ]
        ]);

        $this->assertTrue($response->count() === 0);
    }

    protected function tearDown()
    {
        $this->bucket->deleteBucket();
    }
}
