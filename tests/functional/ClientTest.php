<?php

use PodPoint\MyUtilityGenius\Config;
use PodPoint\MyUtilityGenius\Client;
use kamermans\OAuth2\Persistence\NullTokenPersistence;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Tests\Server;
use Illuminate\Http\Response as IlluminateResponse;

class ClientTest extends TestCase
{
    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        Server::start();
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown()
    {
        Server::stop();
    }

    /**
     * Test a client can make a request and return a response.
     */
    public function testClientRequest()
    {
        $postcodeResponse = [
            'postcodeReadyDto' => [
                'postcodeIsSwitchable' => true,
                'suggestedFormat' => 'sample string 2',
            ],
            'apiVersion' => 'sample string 1',
            'uri' => 'sample string 2',
        ];

        Server::enqueue([
            new Response(IlluminateResponse::HTTP_OK, [], json_encode([
                'access_token' => 'd96tM0nCKx2G1Gz',
                'token_type' => 'bearer',
                'expires_in' => 86399,
            ])),
            new Response(IlluminateResponse::HTTP_OK, [], json_encode($postcodeResponse)),
        ]);

        $config = new Config('id', 'secret', Server::$url, Server::$url);
        $config->setTokenPersistence(new NullTokenPersistence());
        $client = new Client($config);

        $response = $client->json($client->get('request/Address/Postcode/Ready', [
            'query' => ['Postcode' => 'postcode']
        ]));

        $this->assertEquals($postcodeResponse, $response);
    }
}
