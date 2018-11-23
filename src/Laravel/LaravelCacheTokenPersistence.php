<?php

namespace PodPoint\MyUtilityGenius\Laravel;

use Illuminate\Cache\Repository;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\TokenInterface;

class LaravelCacheTokenPersistence implements TokenPersistenceInterface
{
    /**
     * The cache repository.
     *
     * @var Repository
     */
    private $cache;

    /**
     * The cache key.
     *
     * @var string
     */
    private $cacheKey;

    /**
     * Cache constructor.
     *
     * @param Repository $cache
     * @param string $cacheKey
     */
    public function __construct(Repository $cache, $cacheKey = 'guzzle-oauth2-token')
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * Restore the token data into the give token.
     *
     * @param TokenInterface $token
     * @return TokenInterface Restored token
     */
    public function restoreToken(TokenInterface $token)
    {
        $data = $this->cache->get($this->cacheKey);

        if (!is_array($data)) {
            return null;
        }

        return $token->unserialize($data);
    }

    /**
     * Save the token data.
     *
     * @param TokenInterface $token
     */
    public function saveToken(TokenInterface $token)
    {
        $this->cache->forever($this->cacheKey, $token->serialize());
    }

    /**
     * Delete the saved token data.
     */
    public function deleteToken()
    {
        $this->cache->delete($this->cacheKey);
    }

    /**
     * Returns true if a token exists (although it may not be valid)
     *
     * @return bool
     */
    public function hasToken()
    {
        return $this->cache->has($this->cacheKey);
    }
}
