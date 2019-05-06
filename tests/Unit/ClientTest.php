<?php

namespace Tests\Unit;

use Tests\TestCase;
use Needletail\Client;

class ClientTest extends TestCase
{
    /** @test */
    public function testInstantiateClient()
    {
        $client = new Client(
            $this->read_key,
            $this->write_key
        );

        $this->assertInstanceOf(Client::class, $client);
    }
}
