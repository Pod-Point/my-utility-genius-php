<?php

namespace PodPoint\MyUtilityGenius;

use kamermans\OAuth2\Persistence\TokenPersistenceInterface;

class Config
{
    /**
     * The client ID.
     *
     * @var string
     */
    public $clientId;

    /**
     * The client secret.
     *
     * @var string
     */
    public $clientSecret;

    /**
     * The API endpoint.
     *
     * @var string
     */
    public $endpoint;

    /**
     * The authentication endpoint
     *
     * @var string
     */
    public $authEndpoint;

    /**
     * The oAuth scope.
     *
     * @var string
     */
    public $scope;

    /**
     * The response mime type.
     *
     * @var string
     */
    public $mime;

    /**
     * The token persistence storage.
     *
     * @var TokenPersistenceInterface|null
     */
    public $tokenPersistence;

    /**
     * Config constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string|null $endpoint
     * @param string|null $authEndpoint
     * @param string $scope
     * @param string $mime
     */
    public function __construct(
        string $clientId,
        string $clientSecret,
        string $endpoint = 'https://api-home-staging.myutilitygenius.co.uk',
        string $authEndpoint = 'https://authorisation-staging.myutilitygenius.co.uk/connect/token',
        string $scope = 'DomesticApi',
        string $mime = 'application/json'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->endpoint = $endpoint;
        $this->authEndpoint = $authEndpoint;
        $this->scope = $scope;
        $this->mime = $mime;
    }

    /**
     * Set token persistence.
     *
     * @param TokenPersistenceInterface $tokenPersistence
     */
    public function setTokenPersistence(TokenPersistenceInterface $tokenPersistence)
    {
        $this->tokenPersistence = $tokenPersistence;
    }
}
