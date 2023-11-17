# Add kanban boards to your Filament pages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mokhosh/filament-kanban/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mokhosh/filament-kanban/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mokhosh/filament-kanban/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mokhosh/filament-kanban/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require mokhosh/filament-kanban
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-kanban-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-kanban-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-kanban-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentKanban = new Mokhosh\FilamentKanban();
echo $filamentKanban->echoPhrase('Hello, Mokhosh!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mo Khosh](https://github.com/mokhosh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
