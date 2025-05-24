# Vairogs Spaghetti: XLSX Parser - Features

This document lists all the functions available in the Vairogs Spaghetti: XLSX Parser package.

## XLSXParser Class

### open()

```php
public function open(
    string $path,
): XLSXInterface
```

Opens an XLSX file at the specified path and returns an XLSXInterface object for further operations.

Parameters:
- `$path`: The path to the XLSX file to open

Returns an XLSXInterface object that provides access to the workbook's contents.

## XLSX Class (implements XLSXInterface)

### getWorksheets()

```php
public function getWorksheets(
): array
```

Gets a list of all worksheet names in the workbook.

Returns an array of worksheet names.

### getRows()

```php
public function getRows(
    int $index,
): Iterator
```

Gets an iterator for the rows in the specified worksheet.

Parameters:
- `$index`: The index of the worksheet to get rows from

Returns an Iterator that yields each row as an array of values.

### getIndex()

```php
public function getIndex(
    string $name,
): int
```

Gets the index of a worksheet by its name.

Parameters:
- `$name`: The name of the worksheet to find

Returns the index of the worksheet.

Throws:
- `InvalidIndexException`: If the worksheet with the specified name is not found

## Usage Examples

### Basic Usage

```php
use Spaghetti\XLSXParser;

// Open an XLSX file
$workbook = (new XLSXParser())->open('workbook.xlsx');

// Get all worksheet names
$worksheets = $workbook->getWorksheets();

// Get the index of a specific worksheet
$index = $workbook->getIndex('Sheet1');

// Iterate through the rows of a worksheet
foreach ($workbook->getRows($index) as $rowIndex => $rowValues) {
    // Process each row
    var_dump($rowIndex, $rowValues);
}
```

### Using Worksheet Name Directly

```php
use Spaghetti\XLSXParser;

$workbook = (new XLSXParser())->open('workbook.xlsx');

// Get rows from a worksheet by name
$worksheetName = 'Sheet1';
foreach ($workbook->getRows($workbook->getIndex($worksheetName)) as $rowIndex => $rowValues) {
    // Process each row
    var_dump($rowIndex, $rowValues);
}
```

## Implementation Details

The XLSX Parser uses PHP's built-in ZIP and XMLReader extensions to efficiently parse XLSX files without requiring external dependencies. It handles:

- Extracting files from the XLSX archive
- Parsing worksheet data
- Converting shared strings
- Applying cell styles and formats
- Transforming cell values to appropriate PHP types

This implementation is designed to be memory-efficient, making it suitable for processing large XLSX files.
