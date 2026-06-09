# xml

Lazy XML readers and streaming writers for `php-data-streams`.

This package is intended for XML feeds where you want to process one record element at a time without loading the whole document.

## Which Class Should I Use?

- `XmlReader` to stream matching XML elements from a file into PHP arrays.
- `XmlWriter` to write records back into an XML document one at a time.

## Features

- Stream XML records from a large file with `XMLReader`.
- Write XML records incrementally with `XMLWriter`.
- Map each record element to a PHP array.

## Usage

```php
use JLSalinas\DataStreams\Xml\XmlReader;
use JLSalinas\DataStreams\Xml\XmlWriter;

$reader = new XmlReader(__DIR__ . '/feed.xml', 'item');

foreach ($reader as $item) {
    echo $item['title'] . PHP_EOL;
}

$writer = new XmlWriter(__DIR__ . '/export.xml', 'items', 'item');
$writer->write(['title' => 'Example', 'slug' => 'example']);
$writer->close();
```

## Notes

- `XmlReader` only yields elements whose name matches the configured record element.
- `XmlWriter` writes each record as a child element inside the configured root element.
- Values are cast to strings before being written.
