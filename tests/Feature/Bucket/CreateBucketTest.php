<?php

namespace Tests\Feature\Bucket;

use Tests\TestCase;
use Needletail\Client;
use Needletail\Bucket;

class CreateBucketTest extends TestCase
{
    /** @test */
    public function testInitBucketThatDoesNotExist()
    {
        $client = new Client(
            $this->read_key,
            $this->write_key
        );

        $bucket = $client->initBucket('test-bucket-that-does-not-exist');

        $this->assertInstanceOf(Bucket::class, $bucket);

        $this->assertTrue($bucket->exists());

        $bucket->deleteBucket();
    }
}
