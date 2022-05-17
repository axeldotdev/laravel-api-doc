# Laravel API Doc

[![Latest Version on Packagist](https://img.shields.io/packagist/v/axeldotdev/laravel-api-doc.svg?style=flat-square)](https://packagist.org/packages/axeldotdev/laravel-api-doc)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/axeldotdev/laravel-api-doc/run-tests?label=tests)](https://github.com/axeldotdev/laravel-api-doc/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/axeldotdev/laravel-api-doc/Check%20&%20fix%20styling?label=code%20style)](https://github.com/axeldotdev/laravel-api-doc/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/axeldotdev/laravel-api-doc.svg?style=flat-square)](https://packagist.org/packages/axeldotdev/laravel-api-doc)

This package help you build your REST API documentation.

## Installation

You can install the package via composer:

```bash
composer require axeldotdev/laravel-api-doc
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-api-doc-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-api-doc-views"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Axel Charpentier](https://github.com/axeldotdev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
