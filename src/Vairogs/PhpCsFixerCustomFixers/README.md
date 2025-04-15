# Vairogs PHP-CS-Fixer Custom Fixers

A PHP library providing custom fixers for PHP-CS-Fixer to enhance code quality and enforce coding standards.

## Installation

Install the package via Composer:

```bash
composer require vairogs/php-cs-fixer-custom-fixers
```

## Requirements

PHP 8.4 or higher

## Usage

The package provides custom fixers that can be used with PHP-CS-Fixer to automatically fix code style issues.

### Basic Usage

```php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use Vairogs\PhpCsFixerCustomFixers\Fixers;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->name('*.php');

$config = new Config();
$config
    ->setRules([
        '@PSR12' => true,
        // Enable all Vairogs custom fixers
        'VairogsPhpCsFixerCustomFixers/declare_after_opening_tag' => true,
        'VairogsPhpCsFixerCustomFixers/doctrine_migrations' => true,
        'VairogsPhpCsFixerCustomFixers/isset_to_array_key_exists' => true,
        'VairogsPhpCsFixerCustomFixers/line_break_between_method_arguments' => true,
        'VairogsPhpCsFixerCustomFixers/line_break_between_statements' => true,
        'VairogsPhpCsFixerCustomFixers/no_useless_dirname_call' => true,
        'VairogsPhpCsFixerCustomFixers/no_useless_strlen' => true,
        'VairogsPhpCsFixerCustomFixers/promoted_constructor_property' => true,
    ])
    ->setFinder($finder);

// Register custom fixers
$fixers = new Fixers();
foreach ($fixers as $fixer) {
    $config->registerCustomFixers([$fixer]);
}

return $config;
```

### Registering Specific Fixers

If you only want to use specific fixers, you can register them individually:

```php
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use Vairogs\PhpCsFixerCustomFixers\Fixer\DoctrineMigrationsFixer;
use Vairogs\PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->name('*.php');

$config = new Config();
$config
    ->setRules([
        '@PSR12' => true,
        // Enable only specific Vairogs custom fixers
        'VairogsPhpCsFixerCustomFixers/doctrine_migrations' => true,
        'VairogsPhpCsFixerCustomFixers/isset_to_array_key_exists' => true,
    ])
    ->setFinder($finder)
    ->registerCustomFixers([
        new DoctrineMigrationsFixer(),
        new IssetToArrayKeyExistsFixer(),
    ]);

return $config;
```

## Available Fixers

### DeclareAfterOpeningTagFixer

Ensures that `declare(strict_types = 1)` is placed immediately after the opening PHP tag.

### DoctrineMigrationsFixer

Removes unnecessary auto-generated comments from Doctrine migration files.

```php
// Before
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101000000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
    }
}

// After
final class Version20230101000000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
    }
}
```

### IssetToArrayKeyExistsFixer

Replaces `isset($array[$key])` with `array_key_exists($key, $array)` when possible.

```php
// Before
if (isset($array[$key])) {
    echo $array[$key];
}

// After
if (array_key_exists($key, $array)) {
    echo $array[$key];
}
```

Note: This fixer is marked as risky because `isset()` and `array_key_exists()` have slightly different behaviors. `isset()` also checks if the value is not null, while `array_key_exists()` only checks if the key exists.

### LineBreakBetweenMethodArgumentsFixer

Ensures that method arguments are separated by line breaks when there are multiple arguments.

### LineBreakBetweenStatementsFixer

Ensures that statements are separated by line breaks for better readability.

### NoUselessDirnameCallFixer

Removes unnecessary `dirname()` calls.

### NoUselessStrlenFixer

Removes unnecessary `strlen()` calls when used in comparisons.

### PromotedConstructorPropertyFixer

Converts traditional constructor property assignments to promoted properties (PHP 8.0+).

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

If you find these custom fixers useful, you might want to check out the full Vairogs project for additional tools and utilities that can enhance your Symfony application development.

To install the complete package:

```bash
composer require vairogs/vairogs
```
