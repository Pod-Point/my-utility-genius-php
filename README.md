# My Utility Genius PHP SDK

[![Build Status](https://travis-ci.org/Pod-Point/my-utility-genius-php.svg?branch=master)](https://travis-ci.org/Pod-Point/my-utility-genius-php)
[![Packagist](https://img.shields.io/packagist/v/Pod-Point/my-utility-genius-php.svg)](https://packagist.org/packages/pod-point/my-utility-genius-php)

A PHP library for communicating with the My Utility Genius API

[Documentation](https://api-home.myutilitygenius.co.uk/documentation)

## Installation

Require the package in composer:

```javascript
"require": {
    "pod-point/my-utility-genius-php": "^1.0"
},
```

#### Laravel

If you are using a recent version of Laravel the service provider will automatically
be registered. If not update your `config/app.php` providers array:

```php
'providers' => [
    PodPoint\MyUtilityGenius\Providers\ServiceProvider::class
]
```

Then publish the config file:

```php
php artisan vendor:publish --provider="PodPoint\MyUtilityGenius\Providers\ServiceProvider"
```

Finally, remember to set `MUG_CLIENT_ID` and `MUG_CLIENT_SECRET` in your env file.

#### Manually

You can also manually create a Client by passing in a Config object and optionally setting a
token persistence class:

```php
$config = new Config('client-id', 'client-secret');
$config->setTokenPersistence(new FileTokenPersistence('test.db'));
$client = new Client($config);
```

## Usage

You can then use the client to make authenticated requests to the API:

```php
$response = $client->json($client->get('request/Address/Postcode/Ready', [
    'query' => ['Postcode' => 'EC1 7YH']
]));
```
