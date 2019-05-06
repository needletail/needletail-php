<?php

namespace Tests\Feature\Document;

use Tests\TestCase;
use Needletail\Client;

class UpdateTest extends TestCase
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
    public function testUpdateDocument()
    {
        $response = $this->bucket->index([
            'title' => 'Needletail is awesome!'
        ]);

        $this->assertArrayHasKey('success', $response);

        $this->assertTrue($response->success);

        $update_res = $this->bucket->updateDocument($response->document_id, [
            'title' => 'Needletail is still awesome!'
        ]);

        $this->assertArrayHasKey('success', $update_res);

        $this->assertTrue($update_res->success);

        $this->bucket->deleteDocument($response->document_id);
    }
}
