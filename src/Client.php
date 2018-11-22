<?php

namespace PodPoint\MyUtilityGenius;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Signer\ClientCredentials\PostFormData;

class Client extends GuzzleClient
{
    /**
     * Create a new My Utility Genius API client.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $oauth = $this->getMiddleware($config);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        parent::__construct([
            'handler' => $stack,
            'auth'    => 'oauth',
            'base_uri' => $config->endpoint,
            'defaults' => [
                'headers' => [
                    'Accept' => $config->mime
                ],
            ]
        ]);
    }

    /**
     * Get the Guzzle client for making auth requests.
     *
     * @param Config $config
     * @return GuzzleClient
     */
    private function getAuthClient(Config $config)
    {
        return new GuzzleClient([
            'base_uri' => $config->authEndpoint,
        ]);
    }

    /**
     * Build the oAuth Guzzle middleware.
     *
     * @param Config $config
     * @return OAuth2Middleware
     */
    private function getMiddleware(Config $config)
    {
        $authConfig = [
            'client_id' => $config->clientId,
            'client_secret' => $config->clientSecret,
            'scope' => $config->scope,
        ];

        $grantType = new ClientCredentials($this->getAuthClient($config), $authConfig);
        $oauth = new OAuth2Middleware($grantType);

        $oauth->setClientCredentialsSigner(new PostFormData());

        if ($config->tokenPersistence) {
            $oauth->setTokenPersistence($config->tokenPersistence);
        }

        return $oauth;
    }

    /**
     * Decode a JSON response.
     *
     * @param Response $response
     * @return mixed
     */
    public function json(Response $response)
    {
        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
