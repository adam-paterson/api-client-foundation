# API Client Foundation

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require adam-paterson/api-client-foundation
```

## Basic Usage

``` php
$api = new AdamPaterson\ApiClient\Foundation\ApiClient::create();
$response = $api->get('/resource/path', ['param1' => 'param']);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hello@adampaterson.co.uk instead of using the issue tracker.

## Credits

- [Adam Paterson][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/adam-paterson/api-client-foundation.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/adam-paterson/api-client-foundation/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/adam-paterson/api-client-foundation.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/adam-paterson/api-client-foundation.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/adam-paterson/api-client-foundation.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/adam-paterson/api-client-foundation
[link-travis]: https://travis-ci.org/adam-paterson/api-client-foundation
[link-scrutinizer]: https://scrutinizer-ci.com/g/adam-paterson/api-client-foundation/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/adam-paterson/api-client-foundation
[link-downloads]: https://packagist.org/packages/adam-paterson/api-client-foundation
[link-author]: https://github.com/adam-paterson
[link-contributors]: ../../contributors
