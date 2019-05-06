<?php

namespace Tests\Feature\Document;

use Needletail\Client;
use Tests\TestCase;

class DeleteTest extends TestCase
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
    public function testDeleteDocument()
    {
        $document = $this->bucket->index([
            'title' => 'Needletail is awesome!'
        ]);

        $response = $this->bucket->deleteDocument($document->document_id);

        $this->assertArrayHasKey('success', $response);

        $this->assertTrue($response->success);
    }
}
