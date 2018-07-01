# Last.fm SDK for PHP
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md) [![Build Status](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/build.png?b=init)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/build-status/init) [![Code Coverage](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/coverage.png?b=init)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/badges/quality-score.png?b=init)](https://scrutinizer-ci.com/g/sourceout/lastfm-php-sdk/)

This repository contains library the allows you to access Last.fm platform from your PHP application.

For details into how authenticate and obtain API Keys read `Getting Started` under [API Introduction](https://www.last.fm/api)

Read the official API Documents at https://www.last.fm/api/intro for more information.

## Installation
You can install this package via composer using this command:
```bash
composer require php-http/guzzle6-adapter guzzlehttp/psr7 php-http/message sourceout/lastfm-php-sdk
```

Although, the default installation instruction recommends Guzzle Http client it is not the only client that can be used. Refer the following list [php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation) for choices of clients.

For more information on this approach refer this [documentation](http://docs.php-http.org/en/latest/httplug/users.html).

## Usage
```php
use Sourceout\LastFm\Client as LastFmClient;
use Sourceout\LastFm\Provider\LastFm\LastFm;

$provider = new LastFm(
    [
        'api_key' => 'your_api_key_here'
    ]
);

$lastFmClient = new LastFmClient();

$topArtists = $lastFmClient->getServiceFactory($provider)
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

Additionally, although the package features auto-discovery of http package/client, you can also set your own Http Client as well, for e.g.

```php
use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Client as LastFmClient;

$http = new Http();
$http->setHttpClient($customHttpClient);
$http->setMessageFactory($customMessageFactory);

// Method 1
$lastFmClient = new LastFmClient($http);

// Method 2
$lastFmClient->setHttpClient($http);
```

## Tests
You can run the tests with:
```bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING) for details.

## Security
In case, you discover any security related issues, please email pulkit.swarup[at]gmail.com instead of using the issue tracker.

## License
Please see [License File](LICENSE) for more information.
