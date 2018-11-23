<?php

namespace PodPoint\MyUtilityGenius\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\Cache\Repository;
use kamermans\OAuth2\Persistence\SimpleCacheTokenPersistence;
use PodPoint\MyUtilityGenius\Client;
use PodPoint\MyUtilityGenius\Config;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/my-utility-genius.php' => config_path('my-utility-genius.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            $cache = $this->app->make(Repository::class);
            $config = new Config(config('my-utility-genius.auth.client-id'), config('my-utility-genius.auth.secret-key'));
            $config->setTokenPersistence(new SimpleCacheTokenPersistence($cache));

            return new Client($config);
        });
    }
}
