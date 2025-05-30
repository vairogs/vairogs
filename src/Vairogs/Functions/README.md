# Vairogs Functions

A comprehensive collection of PHP utility functions and helpers for various tasks including date manipulation, web operations, text processing, and more. This is a meta-package that includes all the Vairogs function sub-libraries.

## Installation

Install the package via Composer:

```bash
composer require vairogs/functions
```

This will install all the function sub-libraries at once.

## Requirements

- PHP 8.4 or higher
- Various PHP extensions (curl, json, random)
- Symfony components (http-foundation, intl, process, property-access, routing, string)

## Included Sub-libraries

This meta-package includes the following function libraries:

- [vairogs/functions-date](Date) - Date and time manipulation utilities
- [vairogs/functions-handler](Handler) - Error and exception handling utilities
- [vairogs/functions-iteration](Iteration) - Array and collection iteration utilities
- [vairogs/functions-latvian](Latvian) - Latvian language specific utilities
- [vairogs/functions-local](Local) - Localization and internationalization utilities
- [vairogs/functions-memoize](Memoize) - Function result caching utilities
- [vairogs/functions-number](Number) - Number manipulation and formatting utilities
- [vairogs/functions-pagination](Pagination) - Pagination utilities for arrays and collections
- [vairogs/functions-php](Php) - PHP language enhancement utilities
- [vairogs/functions-preg](Preg) - Regular expression utilities
- [vairogs/functions-queue](Queue) - FIFO queue implementation for managing collections of items
- [vairogs/functions-sort](Sort) - Sorting algorithms and utilities
- [vairogs/functions-text](Text) - Text processing and manipulation utilities
- [vairogs/functions-web](Web) - Web-related utilities for HTTP requests, URLs, etc.

Each sub-library can also be installed individually if you only need specific functionality.

## Usage

Each sub-library has its own usage instructions. Please refer to the README.md file in each sub-library's directory for specific usage examples.

Generally, there are two ways to use these libraries:

1. Via the Functions class provided by each sub-library
2. By directly using the traits in your own classes

## License

This package is licensed under the [BSD-3-Clause License](LICENSE).

## About Vairogs

This package is part of the [vairogs/vairogs](https://github.com/vairogs/vairogs) project - a comprehensive PHP library and Symfony bundle that provides a collection of utilities, components, and integrations for Symfony applications. 

The main project includes:
- Various utility functions and components
- Doctrine ORM tools and extensions
- API Platform integrations
- Symfony bundle for easy configuration
- And much more

If you find these function components useful, you might want to check out the full Vairogs project for additional tools and utilities that can enhance your Symfony application development.

To install the complete package:

```bash
composer require vairogs/vairogs
```
