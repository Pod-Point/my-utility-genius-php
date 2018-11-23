<?php

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PodPoint\MyUtilityGenius\Providers\ServiceProvider;
use PodPoint\MyUtilityGenius\Client;

class ServiceProviderTest extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('my-utility-genius.auth.client-id', 'id');
        $app['config']->set('my-utility-genius.auth.secret-key', 'secret');
    }

    /**
     * Test the service provider registers the bindings.
     */
    public function testServiceProvider()
    {
        $client = app()->make(Client::class);
        $config = $client->getConfig('mug');

        $this->assertEquals('https://api-home-staging.myutilitygenius.co.uk', (string) $client->getConfig('base_uri'));
        $this->assertEquals('id', $config->clientId);
        $this->assertEquals('secret', $config->clientSecret);
    }
}
