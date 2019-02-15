<?php

namespace PodPoint\MyUtilityGenius;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Signer\ClientCredentials\PostFormData;
use Psr\Http\Message\ResponseInterface;

class Client extends GuzzleClient
{
    /**
     * The config for My Utility Genius API
     *
     * @var Config
     */
    private $mugConfig;

    /**
     * Create a new My Utility Genius API client.
     *
     * @param Config $mugConfig
     */
    public function __construct(Config $mugConfig)
    {
        $this->mugConfig = $mugConfig;

        $oauth = $this->getMiddleware();

        $stack = HandlerStack::create();
        $stack->push($oauth);

        parent::__construct([
            'handler' => $stack,
            'auth' => 'oauth',
            'base_uri' => $mugConfig->endpoint,
            'mug' => $this->mugConfig,
            'defaults' => [
                'headers' => [
                    'Accept' => $mugConfig->mime
                ],
            ]
        ]);
    }

    /**
     * Get the Guzzle client for making auth requests.
     *
     * @return GuzzleClient
     */
    private function getAuthClient()
    {
        return new GuzzleClient([
            'base_uri' => $this->mugConfig->authEndpoint,
        ]);
    }

    /**
     * Build the oAuth Guzzle middleware.
     *
     * @return OAuth2Middleware
     */
    private function getMiddleware()
    {
        $authConfig = [
            'client_id' => $this->mugConfig->clientId,
            'client_secret' => $this->mugConfig->clientSecret,
            'scope' => $this->mugConfig->scope,
        ];

        $grantType = new ClientCredentials($this->getAuthClient(), $authConfig);
        $oauth = new OAuth2Middleware($grantType);

        $oauth->setClientCredentialsSigner(new PostFormData());

        if ($this->mugConfig->tokenPersistence) {
            $oauth->setTokenPersistence($this->mugConfig->tokenPersistence);
        }

        return $oauth;
    }

    /**
     * Decode a JSON response.
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    public function json(ResponseInterface $response)
    {
        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
