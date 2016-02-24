<?php

namespace Wirecard\Functional;

use Guzzle\Http\Client;

abstract class GatewayTestCase extends FunctionalTestCase
{
    const URL = 'https://c3-test.wirecard.com/secure/ssl-gateway';

    /**
     * @var Client
     */
    protected $client;

    protected $params = [
        'headers' => ['Content-Type' => 'text/xml'],
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->client = new Client();
    }

    protected function createRequest($body)
    {
        return $this->client->createRequest('POST', self::URL, null, $body, $this->params);
    }
}
