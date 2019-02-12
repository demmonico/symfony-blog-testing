<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\BaseWebTestCase;

class StatusControllerTest extends BaseWebTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client->request('GET', '/status');
    }

    public function testShouldGetCorrectResponseFromStatus()
    {
        $response = $this->client->getResponse();

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            'Response format is not JSON'
        );

        $this->assertArraySubset(
            ['status' => 'ok', 'host' => gethostname()],
            json_decode($response->getContent(), true),
            true,
            'Response items is not as desired'
        );
    }
}
