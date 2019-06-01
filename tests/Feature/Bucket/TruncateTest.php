<?php

namespace Tests\Feature\Bucket;

use Tests\TestCase;
use Needletail\Client;
use Needletail\Bucket;

class TruncateTest extends TestCase
{
    /**
     * @var Bucket
     */
    private $bucket;

    protected function setUp()
    {
        parent::setUp();

        $client = new Client(
            $this->read_key,
            $this->write_key
        );

        $this->bucket = $client->initBucket('test-bucket-that-does-not-exist');

        $this->bucket->createBucket();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->bucket->deleteBucket();
    }

    /** @test */
    public function testTruncatingEmptyBucket()
    {
        $response = $this->bucket->truncateBucket();

        $this->assertTrue($response->success === true);
    }

    /** @test */
    public function testTruncatingValidBucket()
    {
        $index_response = $this->bucket->index([
            'title' => 'Needletail is awesome!'
        ]);

        $this->assertArrayHasKey('success', $index_response);

        $this->assertTrue($index_response->success);

        $truncate_response = $this->bucket->truncateBucket();

        $this->assertTrue($truncate_response->success);
    }
}
