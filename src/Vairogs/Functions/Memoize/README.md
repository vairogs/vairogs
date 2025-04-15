# Vairogs Functions: Memoize

A PHP library providing memoization functionality to cache the results of expensive function calls and return the cached result when the same inputs occur again.

## Installation

Install the package via Composer:

```bash
composer require vairogs/functions-memoize
```

## Requirements

PHP 8.4 or higher

## Usage

The Memoize class provides a caching mechanism to store and retrieve values based on a context and keys.

### Basic Usage

```php
use Vairogs\Functions\Memoize\Memoize;
use YourNamespace\YourEnum;

// Create a new Memoize instance
$memoize = new Memoize();

// Cache the result of an expensive function call
$result = $memoize->memoize(
    YourEnum::SOME_VALUE,  // Context (must be a BackedEnum)
    'your-key',            // Key
    function() {           // Callback function whose result will be cached
        // Expensive operation here
        return $expensiveResult;
    }
);

// Later, retrieve the cached value
$cachedResult = $memoize->value(
    YourEnum::SOME_VALUE,  // Same context
    'your-key',            // Same key
    null                   // Default value if not found
);
```

### Advanced Usage with Nested Keys

You can use subkeys for more complex caching scenarios:

```php
// Cache with nested keys
$result = $memoize->memoize(
    YourEnum::SOME_VALUE,  // Context
    'parent-key',          // Main key
    function() {           // Callback
        return $expensiveResult;
    },
    false,                 // Don't refresh the cache
    'child-key',           // Subkey
    'grandchild-key'       // Another level of subkey
);

// Retrieve nested value
$cachedResult = $memoize->value(
    YourEnum::SOME_VALUE,  // Same context
    'parent-key',          // Same main key
    null,                  // Default value
    'child-key',           // Same subkey path
    'grandchild-key'       // Same subkey path
);
```

### Refreshing the Cache

You can force a refresh of the cached value:

```php
$result = $memoize->memoize(
    YourEnum::SOME_VALUE,
    'your-key',
    function() {
        return $newExpensiveResult;
    },
    true  // Set refresh to true to force recalculation
);
```

## Features

For a complete list of all functions available in this package, see [Features](docs/features.md).

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

If you find this Memoize component useful, you might want to check out the full Vairogs project for additional tools and utilities that can enhance your Symfony application development.

To install the complete package:

```bash
composer require vairogs/vairogs
```
