<?php

namespace Tests\Feature\Document;

use Tests\TestCase;
use Needletail\Client;

class IndexTest extends TestCase
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

        $this->bucket = $client->initBucket('vacancies');
    }

    /** @test */
    public function testIndexDocument()
    {
        $response = $this->bucket->index([
            'title' => 'Needletail is awesome!'
        ]);

        $this->assertArrayHasKey('success', $response);

        $this->assertTrue($response->success);

        $this->bucket->deleteDocument($response->document_id);
    }
}
