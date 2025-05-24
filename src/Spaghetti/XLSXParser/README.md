# Spaghetti: XLSX Parser

A blazingly fast XLSX parser for PHP 8.1+ that extracts data from spreadsheets with minimal dependencies.

## Installation

Install the package via Composer:

```bash
composer require spaghetti/xlsx-parser
```

## Requirements

- PHP 8.1 or higher
- PHP extensions: `zip` and `xmlreader`

## Usage

```php
use Spaghetti\XLSXParser;

$workbook = (new XLSXParser())->open('workbook.xlsx');

foreach ($workbook->getRows($workbook->getIndex('worksheet')) as $key => $values) {
    var_dump($key, $values);
}
```

## Features

This package provides a simple and efficient way to parse XLSX files:

1. Initialize the XLSXParser class
2. Open a workbook
3. Choose a worksheet
4. Iterate through rows, receiving each row as an array

For a complete list of all functions available in this package, see [Features](docs/features.md).

## License

This package is licensed under the [MIT License](LICENSE).

## Package History

**Note:** This package was originally developed as "spaghetti/xlsx-parser" by simpletoimplement. Vairogs is the new owner who has been granted permission by the original owner to take over the project.

## About Vairogs

This package is part of the [vairogs/vairogs](https://github.com/vairogs/vairogs) project - a comprehensive PHP library and Symfony bundle that provides a collection of utilities, components, and integrations for Symfony applications.

The main project includes:
- Various utility functions and components
- Doctrine ORM tools and extensions
- API Platform integrations
- Symfony bundle for easy configuration
- And much more

If you find this XLSX Parser component useful, you might want to check out the full Vairogs project for additional tools and utilities that can enhance your Symfony application development.

To install the complete package:

```bash
composer require vairogs/vairogs
```

---
[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://vshymanskyy.github.io/StandWithUkraine)
