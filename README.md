![header](./.github/resources/logo.png)

# Image generator for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/freshbitsweb/image-generator-for-laravel.svg?style=flat-square)](https://packagist.org/packages/freshbitsweb/image-generator-for-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/freshbitsweb/image-generator-for-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/freshbitsweb/image-generator-for-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/freshbitsweb/image-generator-for-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/freshbitsweb/image-generator-for-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/freshbitsweb/image-generator-for-laravel.svg?style=flat-square)](https://packagist.org/packages/freshbitsweb/image-generator-for-laravel)

This package allows you to generate images using a command in your Laravel web apps.

## Installation

You can install the package via composer:

```bash
composer require freshbitsweb/image-generator-for-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="image-generator-for-laravel-config"
```

## Usage

### Generate an image
To generate an image, run the following command:
```bash
php artisan generate:image
```
This will prompt you to input the name, height, and width of the image you want to generate.

### Generate an image with a specific message
To generate an image with a specific message, run the following command:

```bash
php artisan generate:image 'Hello World!!'
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Utsav Somaiya](https://github.com/utsavsomaiya)
- [Gaurav Makhecha](https://github.com/gauravmak)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
