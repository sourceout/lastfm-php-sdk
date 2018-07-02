# Last.fm SDK for PHP
[![Latest Version](https://img.shields.io/github/release/sourceout/lastfm-php-sdk.svg)
](https://github.com/sourceout/lastfm-php-sdk/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md) [![Build Status](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/?branch=master)

This repository contains library the allows you to access Last.fm platform from your PHP application.

For details into how authenticate and obtain API Keys read `Getting Started` under [API Introduction](https://www.last.fm/api)

Read the official API Documents at https://www.last.fm/api/intro for more information.

## Features
Undermentioned is a list of feature this library provides:

* Support for custom implementations (providers)
* Choice of library used to for sending HTTP Requests
* Framework Agnostic
* Flexible & easy to extend

## Installation
You can install this package via composer using this command:
```bash
composer require php-http/guzzle6-adapter guzzlehttp/psr7 php-http/message sourceout/lastfm-php-sdk
```

Although, the default installation instruction recommends Guzzle Http client it is not the only client that can be used. Refer the following list [php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation) for choices of clients.

For more information on this approach refer this [documentation](http://docs.php-http.org/en/latest/httplug/users.html).

## Usage
```php
use Sourceout\LastFm\ProviderInterface;
use Sourceout\LastFm\Client as LastFmClient;
use Sourceout\LastFm\Provider\LastFm\LastFm;

/** @var ProviderInterface $provider */
$provider = new LastFm(['api_key' => 'your_api_key_here']);

/** @var LastFmClient $lastFmClient */
$lastFmClient = new LastFmClient();

/** @var Collection $topArtists */
$topArtists = $lastFmClient
    ->getServiceFactory($provider)
    ->getGeoService()
    ->getTopArtists(
        'united states',    // location
        1,                  // page number
        50                  // results per page
    );
```

You can also register your own custom provider instead of using the default, for e.g.
```php
use Sourceout\LastFm\Client as LastFmClient;

$lastFmClient = new LastFmClient();

$lastFmClient->registerCustomProviders(
    [
        \path\to\custom\provider::class
        ...
        ...
    ]
);
```
Additionally, although the package features auto-discovery of http package/client, you can also set your own Http Client as well, below are examples where you provide Guzzle6 instance.

#### Method 1
```php
use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Client as LastFmClient;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;

/** @var HttpInterface $http */
$http = new Http();

$http->setHttpClient(new GuzzleClient());
$http->setMessageFactory(new GuzzleMessageFactory());

/** @var LastFmClient $lastFmClient */
$lastFmClient = new LastFmClient($http);

```

#### Method 2
```php
use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Client as LastFmClient;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;

/** @var HttpInterface $http */
$http = new Http();

$http->setHttpClient(new GuzzleClient());
$http->setMessageFactory(new GuzzleMessageFactory());

/** @var LastFmClient $lastFmClient */
$lastFmClient = new LastFmClient();
$lastFmClient->setHttpClient($http);
```
## Supported Methods
There is a long list of API(s) provided by LastFm (ref.: https://www.last.fm/api), undermentioned is the list of methods currently supported by this library:

| Geo               |                                                                 |
| :-----------------|:----------------------------------------------------------------|
| Geo.getTopArtists | Get the most popular artists on Last.fm by country              |
| Geo.getTopTracks  | Get the most popular tracks on Last.fm last week by country     |

## Tests
You can run the tests with:
```bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING) for details.

## Security
In case, you discover any security related issues, please email pulkit.swarup@gmail.com instead of using the issue tracker.

## License
Please see [License File](LICENSE) for more information.
